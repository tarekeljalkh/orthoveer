<?php

namespace App\Http\Controllers\Lab;

use App\Events\ScanCreateEvent;
use App\Http\Controllers\Controller;
use App\Mail\ScanCreated;
use App\Mail\ScanCreatedToLab;
use App\Mail\ScanRejected;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Patient;
use App\Models\Scan;
use App\Models\Status;
use App\Models\TypeofWork;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

    public function new()
    {
        $labId = Auth::user()->id;

        // Retrieve all scans assigned to the lab where the latest status is 'new'
        $scans = Scan::with(['doctor', 'latestStatus' => function ($query) {
            $query->where('status', 'new');
        }])
            ->where('lab_id', $labId)
            ->get();

        // Filter the scans to ensure they have the latest status as 'new'
        $newScans = $scans->filter(function ($scan) {
            return $scan->latestStatus && $scan->latestStatus->status === 'new';
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
        //$patients = Patient::where('doctor_id', Auth::user()->id)->get();
        $doctors = User::where('role', 'doctor')->get();
        $patients = Patient::all();
        $typeofWorks = TypeofWork::all();
        return view('lab.scans.create', compact('doctors', 'patients', 'typeofWorks'));
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
        // Validate the input
        $request->validate([
            'stl_upper' => 'nullable|file',
            'stl_lower' => 'nullable|file',
            'doctor_first_name' => 'required|string',
            'doctor_last_name' => 'required|string',
            'doctor_email' => 'required|email',
            'patient_first_name' => 'required|string',
            'patient_last_name' => 'required|string',
            'patient_dob' => 'required|date',
            'patient_gender' => 'required|string|in:male,female',
        ]);

        if (!$request->hasFile('stl_upper') && !$request->hasFile('stl_lower')) {
            toastr()->warning('Please upload at least one STL file (upper or lower).');
            return redirect()->back();
        }

        // Handle doctor information
        $doctor = null;
        if ($request->has('doctor_id')) {
            try {
                $doctor = User::findOrFail($request->doctor_id);
                $doctor->first_name = $request->doctor_first_name;
                $doctor->last_name = $request->doctor_last_name;
                $doctor->email = $request->doctor_email;
                $doctor->save();
            } catch (\Exception $e) {
                toastr()->warning('Selected doctor not found.');
                return redirect()->back();
            }
        } else {
            // Add new Doctor
            $doctor = new User();
            $doctor->role = 'doctor';
            $doctor->first_name = $request->doctor_first_name;
            $doctor->last_name = $request->doctor_last_name;
            $doctor->email = $request->doctor_email;
            $doctor->password = bcrypt('password');
            $doctor->save();
        }

        // Handle patient information
        $patient = null;
        if ($request->has('patient_id')) {
            try {
                $patient = Patient::findOrFail($request->patient_id);
                $patient->first_name = $request->patient_first_name;
                $patient->last_name = $request->patient_last_name;
                $patient->dob = $request->patient_dob;
                $patient->gender = $request->patient_gender;
                $patient->save();
            } catch (\Exception $e) {
                toastr()->warning('Selected patient not found.');
                return redirect()->back();
            }
        } else {
            // Add new patient for this doctor
            $patient = new Patient();
            $patient->doctor_id = $doctor->id;
            $patient->first_name = $request->patient_first_name;
            $patient->last_name = $request->patient_last_name;
            $patient->dob = $request->patient_dob;
            $patient->gender = $request->patient_gender;

            // Generate a unique chart number
            $datePart = date('y-m-d');
            $nineDigitNumber = mt_rand(100000000, 999999999);
            $finalNumber = "{$datePart}-{$nineDigitNumber}";

            $patient->chart_number = $finalNumber;
            $patient->save();
        }

        $upperPath = $this->uploadImage($request, 'stl_upper');
        $lowerPath = $this->uploadImage($request, 'stl_lower');

        // Handling multiple file uploads
        $pdfPaths = $this->uploadFiles($request, 'pdf');

        // Add or update scan
        $scan = new Scan();
        $scan->doctor_id = $doctor->id;
        $scan->patient_id = $patient->id;

        // Add lab id from type of work id
        $type = TypeofWork::findOrFail($request->typeofwork_id);
        $scan->type_id = $request->typeofwork_id;
        $scan->lab_id = $type->lab_id;
        $scan->second_lab_id = $type->second_lab_id;
        $scan->external_lab_id = $type->external_lab_id;

        $scan->due_date = $request->due_date;
        $scan->stl_upper = $upperPath;
        $scan->stl_lower = $lowerPath;
        $scan->pdf = json_encode($pdfPaths);
        $scan->scan_date = now();
        $scan->save();

        // Create a new status update for the scan
        $statusUpdate = new Status([
            'scan_id' => $scan->id,
            'status' => 'new',
            'note' => $request->note,
            'updated_by' => Auth::id(),
        ]);

        $statusUpdate->save();

        // Send Email
        $lab = User::findOrFail($type->lab_id);
        $content = [
            'doctorName' => 'Dr. ' . $doctor->first_name,
            'dueDate' => $scan->due_date->format('d-m-y'),
            'scanDate' => now()->format('d-m-y'),
            'patientName' => $scan->patient->first_name,
            'labName' => Auth::user()->last_name,
        ];

        try {
            Mail::to(Auth::user()->email)->send(new ScanCreated($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name));
            Mail::to($lab->email)->send(new ScanCreatedToLab($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name));
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
        }

        // Send Notification
        $notification = new Notification();
        $notification->sender_id = Auth::user()->id;
        $notification->receiver_id = $doctor->id;
        $notification->message = 'New Scan Created';
        $notification->scan_id = $scan->id;
        $notification->save();

        toastr()->success(trans('messages.scan_created_successfully'));
        return to_route('lab.scans.index');
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
            'stl_upper_lab' => 'nullable|file',
            'stl_lower_lab' => 'nullable|file',
        ]);

        if (!$request->hasFile('stl_upper_lab') && !$request->hasFile('stl_lower_lab')) {
            // Using Toastr to display an error message
            toastr()->warning('Please upload at least one STL file (upper or lower).');
            return redirect()->back();
        }

        $upperPath = $this->uploadImage($request, 'stl_upper_lab');
        $lowerPath = $this->uploadImage($request, 'stl_lower_lab');

        //find scan id
        $scan = Scan::findOrFail($id);

        $scan->stl_upper = $upperPath;
        $scan->stl_lower = $lowerPath;

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

        // Check if a status update already exists
        $existingStatus = Status::where('scan_id', $scan->id)
            ->where('status', 'downloaded')
            ->first();

        if (!$existingStatus) {
            // Create a new status update for the scan
            $statusUpdate = new Status([
                'scan_id' => $scan->id,
                'status' => 'downloaded',
                'note' => 'Downloaded',
                'updated_by' => Auth::id(),
            ]);

            $statusUpdate->save();
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

            // Create a new status update for the scan
            $statusUpdate = new Status([
                'scan_id' => $scan->id,
                'status' => 'downloaded', // Setting the initial status to 'pending'
                'note' => 'Downloaded', // Assuming the note comes from the request
                'updated_by' => Auth::id(), // Assuming the current user made this update
            ]);
        } else {
            Log::error('Could not open ZIP file for creation at path: ' . $zipFilePath);
            return back()->withErrors('Could not create ZIP file.');
        }
    }
}
