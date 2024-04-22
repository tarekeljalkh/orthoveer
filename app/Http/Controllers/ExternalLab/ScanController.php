<?php

namespace App\Http\Controllers\ExternalLab;

use App\Events\ScanCreateEvent;
use App\Http\Controllers\Controller;
use App\Mail\ScanRejected;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Scan;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use ZipArchive;
use App\Traits\FileUploadTrait;

class ScanController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labId = Auth::user()->id;

        // First, retrieve all scans for the lab within the current month.
        $scans = Scan::with(['doctor', 'latestStatus']) // Assuming 'status' relation loads necessary data to determine current status
            ->where('lab_id', $labId)
            ->get();

        // Then, filter the scans based on the 'current_status' accessor to find those that are pending.
        // Note: This filtering happens in memory, not in the database.


        return view('external_lab.scans.index', compact('scans'));
    }

    public function pending()
    {
        $labId = Auth::user()->id;

        // First, retrieve all scans for the lab within the current month.
        $scans = Scan::with(['doctor', 'status']) // Assuming 'status' relation loads necessary data to determine current status
            ->where('lab_id', $labId)
            ->get();

        // Then, filter the scans based on the 'current_status' accessor to find those that are pending.
        // Note: This filtering happens in memory, not in the database.
        $pendingScans = $scans->filter(function ($scan) {
            return $scan->current_status == 'pending';
        });


        return view('external_lab.scans.pending', compact('pendingScans'));
    }

    public function new()
    {
        $labId = Auth::user()->id;

        // First, retrieve all scans for the lab within the current month.
        $scans = Scan::with(['doctor', 'status']) // Assuming 'status' relation loads necessary data to determine current status
            ->where('lab_id', $labId)
            ->whereMonth('created_at', now()->month)
            ->get();

        // Then, filter the scans based on the 'current_status' accessor to find those that are pending.
        // Note: This filtering happens in memory, not in the database.
        $newScans = $scans->filter(function ($scan) {
            return $scan->current_status == 'pending';
        });

        return view('external_lab.scans.new', compact('newScans'));
    }

    public function downloadStl(Scan $scan)
    {
        $zip = new ZipArchive;
        $zipFileName = "stl-files-{$scan->id}.zip";
        $zipFilePath = public_path($zipFileName); // Adjust based on where you want to save the zip temporarily

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $upperFilePath = public_path('uploads/' . basename($scan->stl_upper)); // Adjust path as needed
            $lowerFilePath = public_path('uploads/' . basename($scan->stl_lower)); // Adjust path as needed

            if (file_exists($upperFilePath)) {
                $zip->addFile($upperFilePath, basename($scan->stl_upper));
            }
            if (file_exists($lowerFilePath)) {
                $zip->addFile($lowerFilePath, basename($scan->stl_lower));
            }

            // Decode the JSON string containing PDF paths to an array
            $pdfPaths = json_decode($scan->pdf, true) ?? [];

            foreach ($pdfPaths as $pdfPath) {
                // Adjust the path and add each PDF file to the ZIP archive
                $pdfFilePath = public_path($pdfPath);
                if (file_exists($pdfFilePath)) {
                    $zip->addFile($pdfFilePath, basename($pdfPath));
                }
            }

            $zip->close();

            return response()->download($zipFilePath)->deleteFileAfterSend(true);
            return redirect()->back();
        } else {
            return back()->withError('Could not create ZIP file.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|max:200',
            'action' => 'required|in:reject,complete',
        ]);

        $scan = Scan::findOrFail($id);

        $action = $request->input('action');
        $status = $action === 'reject' ? 'rejected' : 'completed';

        // Create a new status update for the scan
        $statusUpdate = new Status([
            'scan_id' => $scan->id,
            'status' => $status,
            'note' => $request->input('note'), // Use the same input for the note, regardless of action
            'updated_by' => auth()->user()->id,
        ]);
        $statusUpdate->save();

        // Your existing logic for notifications and emails continues here...

        // Send Email
        $doctor = User::findOrFail($scan->doctor_id);
        $content = [
            'lab' => 'Lab. ' . Auth::user()->first_name,
            'doctorName' => $doctor->first_name, // Assuming you have the doctor's name available
            'scanDate' => now()->format('d-m-y'),
            'patientName' => $scan->patient->first_name,
            'note' => $statusUpdate->note,
            // Include other data as needed
        ];

        try {
            Mail::to($doctor->email)->send(new ScanRejected($content, Auth::user()->email, 'Lab. ' . Auth::user()->first_name)); //$content, 'custom@example.com', 'Custom Name'
            Mail::to(Auth::user()->email)->send(new ScanRejected($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name)); //$content, 'custom@example.com', 'Custom Name'
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
        }

        //Mail::to($doctor->email)->send(new ScanRejected($content, Auth::user()->email, 'Lab. ' . Auth::user()->first_name)); //$content, 'custom@example.com', 'Custom Name'

        //send Notification
        $notification = new Notification();
        $notification->sender_id = Auth::user()->id;
        $notification->receiver_id = $doctor->id;
        $notification->message = $scan->note;
        $notification->scan_id = $scan->id;
        $notification->save();

        toastr()->success('Scan Returned to Doctor Successfully!');

        return back();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function viewer($id)
    {
        //$order = Scan::findOrFail($id);
        $scan = Scan::with('status')->findOrFail($id); // Assuming the correct relationship name is 'status'
        $external_labs = User::where('role', 'external_lab')->get();
        return view('external_lab.viewer.index', compact('scan', 'external_labs'));
    }

    public function prescription($id)
    {
        //$order = Scan::findOrFail($id);
        $scan = Scan::with('status')->findOrFail($id);
        return view('external_lab.prescription.index', compact('scan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //$order = Scan::findOrFail($id);
        $scan = Scan::with('status')->findOrFail($id); // Assuming the correct relationship name is 'status']
        return view('external_lab.scans.view', compact('scan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function downloadMultiple(Request $request)
    {
        $ids = $request->ids; // Array of Scan IDs
        $zip = new ZipArchive;
        $zipFileName = "stl-files-" . now()->format('Ymd-His') . ".zip";
        $zipFilePath = public_path($zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($ids as $id) {
                $scan = Scan::findOrFail($id); // Make sure to handle the case where ID is invalid
                $this->addFilesToZip($scan, $zip);
            }

            $zip->close();
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            return back()->withError('Could not create ZIP file.');
        }
    }

    protected function addFilesToZip($scan, $zip)
    {
        $upperFilePath = public_path('uploads/' . basename($scan->stl_upper));
        $lowerFilePath = public_path('uploads/' . basename($scan->stl_lower));

        if (file_exists($upperFilePath)) {
            $zip->addFile($upperFilePath, basename($scan->stl_upper));
        }
        if (file_exists($lowerFilePath)) {
            $zip->addFile($lowerFilePath, basename($scan->stl_lower));
        }

        $pdfPaths = json_decode($scan->pdf, true) ?? [];
        foreach ($pdfPaths as $pdfPath) {
            $pdfFilePath = public_path($pdfPath);
            if (file_exists($pdfFilePath)) {
                $zip->addFile($pdfFilePath, basename($pdfPath));
            }
        }
    }

    public function complete(Request $request, $id)
    {
        $request->validate([
            'lab_file' => 'required|file|mimes:zip', // Allow only ZIP files
        ]);

        //find scan id
        $scan = Scan::findOrFail($id);

        $file = $this->uploadImage($request, 'lab_file');
        $scan->lab_file = $file;
        $scan->save();

        // Create a new status update for the scan
        $statusUpdate = new Status([
            'scan_id' => $scan->id,
            'status' => 'completed', // Setting the initial status to 'pending'
            'note' => 'Completed', // Assuming the note comes from the request
            'updated_by' => Auth::id(), // Assuming the current user made this update
        ]);

        $statusUpdate->save();


        // Send Email
        // $lab = User::findorFail($type->lab_id);
        // $content = [
        //     'doctorName' => 'Dr. ' . Auth::user()->last_name,
        //     'dueDate' => $scan->due_date->format('d-m-y'),
        //     'scanDate' => now()->format('d-m-y'),
        //     // Include other data as needed
        // ];

        // try {
        //     Mail::to($lab->email)->send(new OrderPlaced($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name));
        // } catch (\Exception $e) {
        //     // Handle email sending failure, log error, etc.
        // }

        //Mail::to($lab->email)->send(new ScanCreated($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name)); //$content, 'custom@example.com', 'Custom Name'

        //send Notification
        // $notification = new Notification();
        // $notification->sender_id = Auth::user()->id;
        // $notification->receiver_id = $lab->id;
        // $notification->message = 'New Scan Created';
        // $notification->scan_id = $scan->id;
        // $notification->save();


        toastr()->success('Scan Completed Successfully');
        return to_route('external_lab.dashboard');
    }

    public function reassignScan(Request $request, $scanId)
    {
        $this->validate($request, [
            'external_lab_id' => 'required|exists:users,id' // Ensure the reassigned lab exists
        ]);

        $scan = Scan::findOrFail($scanId);
        $scan->external_lab_id = $request->external_lab_id;
        $scan->save();

        return redirect()->back()->with('success', 'Scan successfully reassigned to another lab.');
    }
}
