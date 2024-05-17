<?php

namespace App\Http\Controllers\Lab;

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
use Madnest\Madzipper\Facades\Madzipper;
use App\Traits\FileUploadTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use ZipArchive;

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


        return view('lab.scans.index', compact('scans'));
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


        return view('lab.scans.pending', compact('pendingScans'));
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

        return view('lab.scans.new', compact('newScans'));
    }


    // public function printScan(Scan $scan)
    // {
    //     $pdf = PDF::loadView('lab.print', compact('scan'));
    //     return $pdf->download('prescription.pdf');
    // }
    public function printScan(Request $request, $scanId)
    {
        $scan = Scan::findOrFail($scanId);
        $pdf = PDF::loadView('lab.print', compact('scan'));
        return $pdf->download('prescription-' . $scan->id . '.pdf');
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
        return view('lab.viewer.index', compact('scan', 'external_labs'));
    }

    public function prescription($id)
    {
        //$order = Scan::findOrFail($id);
        $scan = Scan::with('status')->findOrFail($id);
        return view('lab.prescription.index', compact('scan'));
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
        return view('lab.scans.view', compact('scan'));
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
        return to_route('lab.dashboard');
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

    protected function addFilesToZip($scan, $zip)
    {
        $upperFilePath = public_path('uploads/' . basename($scan->stl_upper));
        $lowerFilePath = public_path('uploads/' . basename($scan->stl_lower));

        if (file_exists($upperFilePath)) {
            $zip->add($upperFilePath);
        }
        if (file_exists($lowerFilePath)) {
            $zip->add($lowerFilePath);
        }

        $pdfPaths = json_decode($scan->pdf, true) ?? [];
        foreach ($pdfPaths as $pdfPath) {
            $pdfFilePath = public_path($pdfPath);
            if (file_exists($pdfFilePath)) {
                $zip->add($pdfFilePath);
            }
        }
    }

    public function downloadStl(Scan $scan)
    {
        $zipFileName = "stl-files-{$scan->id}.zip";
        $zipFilePath = public_path($zipFileName);

        // Check if directory is writable
        if (!is_writable(public_path())) {
            Log::error("Directory is not writable: " . public_path());
            return back()->withErrors('Directory is not writable.');
        }

        // Create a temporary zip file
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
            Log::error("Could not open ZIP file at path: {$zipFilePath}");
            return back()->withErrors('Could not create ZIP file.');
        }

        // Add STL upper file if it exists
        $upperFilePath = public_path('uploads/' . basename($scan->stl_upper));
        if (file_exists($upperFilePath) && is_file($upperFilePath)) {
            $zip->addFile($upperFilePath, basename($upperFilePath));
        } else {
            Log::error("Upper STL file not found or is not a file: {$upperFilePath}");
        }

        // Add STL lower file if it exists
        $lowerFilePath = public_path('uploads/' . basename($scan->stl_lower));
        if (file_exists($lowerFilePath) && is_file($lowerFilePath)) {
            $zip->addFile($lowerFilePath, basename($lowerFilePath));
        } else {
            Log::error("Lower STL file not found or is not a file: {$lowerFilePath}");
        }

        // Add PDF files if they exist
        $pdfPaths = json_decode($scan->pdf, true) ?? [];
        foreach ($pdfPaths as $pdfPath) {
            $pdfFilePath = public_path($pdfPath);
            if (file_exists($pdfFilePath) && is_file($pdfFilePath)) {
                $zip->addFile($pdfFilePath, basename($pdfFilePath));
            } else {
                Log::error("PDF file not found or is not a file: {$pdfFilePath}");
            }
        }

        if (!$zip->close()) {
            Log::error("Could not close ZIP file at path: {$zipFilePath}");
            return back()->withErrors('Could not create ZIP file.');
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function printMultiple(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            Log::error('No scans selected.');
            return response()->json(['error' => 'No scans selected.'], 400);
        }

        $zipFileName = "multiple-scans.zip";
        $zipFilePath = public_path($zipFileName);

        if (!is_writable(public_path())) {
            Log::error("Directory is not writable: " . public_path());
            return back()->withErrors('Directory is not writable.');
        }

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($ids as $id) {
                $scan = Scan::findOrFail($id);

                $upperFilePath = public_path('uploads/' . basename($scan->stl_upper));
                $lowerFilePath = public_path('uploads/' . basename($scan->stl_lower));

                if (file_exists($upperFilePath) && is_file($upperFilePath)) {
                    $zip->addFile($upperFilePath, "{$id}/" . basename($upperFilePath));
                } else {
                    Log::error("Upper STL file not found or is not a file for scan ID {$id}: {$upperFilePath}");
                }

                if (file_exists($lowerFilePath) && is_file($lowerFilePath)) {
                    $zip->addFile($lowerFilePath, "{$id}/" . basename($lowerFilePath));
                } else {
                    Log::error("Lower STL file not found or is not a file for scan ID {$id}: {$lowerFilePath}");
                }

                $pdfPaths = json_decode($scan->pdf, true) ?? [];
                foreach ($pdfPaths as $pdfPath) {
                    $pdfFilePath = public_path($pdfPath);
                    if (file_exists($pdfFilePath) && is_file($pdfFilePath)) {
                        $zip->addFile($pdfFilePath, "{$id}/" . basename($pdfFilePath));
                    } else {
                        Log::error("PDF file not found or is not a file for scan ID {$id}: {$pdfFilePath}");
                    }
                }
            }

            if (!$zip->close()) {
                Log::error("Could not close ZIP file at path: {$zipFilePath}");
                return back()->withErrors('Could not create ZIP file.');
            }

            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            Log::error('Could not open ZIP file for creation at path: ' . $zipFilePath);
            return back()->withErrors('Could not create ZIP file.');
        }
    }


}
