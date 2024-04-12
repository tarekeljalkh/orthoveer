<?php

namespace App\Http\Controllers\Lab;

use App\Events\ScanCreateEvent;
use App\Http\Controllers\Controller;
use App\Mail\scanRejected;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Scan;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use ZipArchive;

class ScanController extends Controller
{
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

    public function downloadStl(Scan $order)
    {
        $zip = new ZipArchive;
        $zipFileName = "stl-files-{$order->id}.zip";
        $zipFilePath = public_path($zipFileName); // Adjust based on where you want to save the zip temporarily

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $upperFilePath = public_path('uploads/' . basename($order->stl_upper)); // Adjust path as needed
            $lowerFilePath = public_path('uploads/' . basename($order->stl_lower)); // Adjust path as needed

            if (file_exists($upperFilePath)) {
                $zip->addFile($upperFilePath, basename($order->stl_upper));
            }
            if (file_exists($lowerFilePath)) {
                $zip->addFile($lowerFilePath, basename($order->stl_lower));
            }

            // Decode the JSON string containing PDF paths to an array
            $pdfPaths = json_decode($order->pdf, true) ?? [];

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
            'note' => $scan->note,
            // Include other data as needed
        ];
        Mail::to($doctor->email)->send(new ScanRejected($content, Auth::user()->email, 'Lab. ' . Auth::user()->first_name)); //$content, 'custom@example.com', 'Custom Name'

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
        return view('lab.viewer.index', compact('scan'));
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
        //
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
}
