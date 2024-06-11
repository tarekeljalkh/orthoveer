<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Mail\ScanCreated;
use App\Mail\ScanCreatedToLab;
use App\Models\Notification;
use App\Models\Patient;
use App\Models\Scan;
use App\Models\Status;
use App\Models\TypeofWork;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ScanController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd(Auth::user()->patients); relationship inside User Model
        $patients = Patient::where('doctor_id', Auth::user()->id)->get();
        $typeofWorks = TypeofWork::all();
        return view('doctor.scans.create', compact('patients', 'typeofWorks'));
    }

    public function newScan($id)
    {
        $patient = Patient::findOrFail($id);
        $typeofWorks = TypeofWork::all();
        return view('doctor.patients.new_scan', compact('patient', 'typeofWorks'));
    }

    public function newScanStore(Request $request, $id)
    {

        // Validate the input
        $request->validate([
            'stl_upper' => 'nullable|file',
            'stl_lower' => 'nullable|file',
        ]);

        if (!$request->hasFile('stl_upper') && !$request->hasFile('stl_lower')) {
            // Using Toastr to display an error message
            toastr()->warning('Please upload at least one STL file (upper or lower).');
            return redirect()->back();
        }


        //find patient id
        $patient = Patient::findOrFail($id);

        $upperPath = $this->uploadImage($request, 'stl_upper');
        $lowerPath = $this->uploadImage($request, 'stl_lower');

        // Handling multiple file uploads
        $pdfPaths = $this->uploadFiles($request, 'pdf');


        // Add scan to patient
        $scan = new Scan();
        $scan->doctor_id = $request->doctor_id; // Ensure this doctor_id is either coming from authenticated user or safely validated
        $scan->patient_id = $patient->id;
        //add lab id from type of work id
        $type = TypeofWork::findOrFail($request->typeofwork_id);
        $scan->type_id = $request->typeofwork_id;
        $scan->lab_id = $type->lab_id;
        $scan->second_lab_id = $type->second_lab_id;
        $scan->external_lab_id = $type->external_lab_id;
        //
        $scan->due_date = $request->due_date;
        $scan->stl_upper = $upperPath;
        $scan->stl_lower = $lowerPath;
        $scan->pdf = json_encode($pdfPaths);

        $scan->scan_date = now();
        //$scan->note = $request->note;
        $scan->save();

        // Create a new status update for the scan
        $statusUpdate = new Status([
            'scan_id' => $scan->id,
            'status' => 'new', // Setting the initial status to 'pending'
            'note' => $request->note, // Assuming the note comes from the request
            'updated_by' => Auth::id(), // Assuming the current user made this update
        ]);

        $statusUpdate->save();

        // Send Email
        $lab = User::findorFail($type->lab_id);
        $content = [
            'doctorName' => 'Dr. ' . Auth::user()->last_name,
            'dueDate' => $scan->due_date->format('d-m-y'),
            'scanDate' => now()->format('d-m-y'),
            'patientName' => $scan->patient->first_name,
            'labName' => $lab->first_name,
            'scanId' => $scan->id,
            'doctor_scan_url' => route('doctor.scans.index'),
            'lab_scan_url' => route('lab.scans.viewer', ['id' => $scan->id]),
            'scan_due_date' => $scan->due_date->addDays($type->lab_due_date)->format('d-m-y'),
        ];

        try {
            Mail::to(Auth::user()->email)->send(new ScanCreated($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name)); //$content, 'custom@example.com', 'Custom Name'
            Mail::to($lab->email)->send(new ScanCreatedToLab($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name)); //$content, 'custom@example.com', 'Custom Name'
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
        }

        //Mail::to($lab->email)->send(new ScanCreated($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name)); //$content, 'custom@example.com', 'Custom Name'

        //send Notification
        $notification = new Notification();
        $notification->sender_id = Auth::user()->id;
        $notification->receiver_id = $lab->id;
        $notification->message = 'New Scan Created';
        $notification->scan_id = $scan->id;
        $notification->save();


        toastr()->success(trans('messages.scan_created_successfully'));
        return to_route('doctor.patients.show', $patient->id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        ]);

        if (!$request->hasFile('stl_upper') && !$request->hasFile('stl_lower')) {
            // Using Toastr to display an error message
            toastr()->warning('Please upload at least one STL file (upper or lower).');
            return redirect()->back();
        }


        // Check if a patient is selected and exists
        if ($request->has('patient_id') && $patient = Patient::findOrFail($request->patient_id)) {
            // Update the existing patient
            $patient->first_name = $request->patient_first_name;
            $patient->last_name = $request->patient_last_name;
            $patient->dob = $request->patient_dob;
            $patient->gender = $request->patient_gender;
            $patient->save();
        } else {
            // Add new patient for this doctor
            $patient = new Patient();
            $patient->doctor_id = $request->doctor_id; // Ensure this doctor_id is either coming from authenticated user or safely validated
            $patient->first_name = $request->patient_first_name;
            $patient->last_name = $request->patient_last_name;
            $patient->dob = $request->patient_dob;
            $patient->gender = $request->patient_gender;

            // Step 1: Generate the date part (y-m-d)
            $datePart = date('y-m-d');
            // Step 2: Generate a 9-digit number
            $nineDigitNumber = mt_rand(100000000, 999999999);
            // Step 3: Concatenate the parts
            $finalNumber = "{$datePart}-{$nineDigitNumber}";

            $patient->chart_number = $finalNumber;
            $patient->save();
        }

        $upperPath = $this->uploadImage($request, 'stl_upper');
        $lowerPath = $this->uploadImage($request, 'stl_lower');

        // Handling multiple file uploads
        $pdfPaths = $this->uploadFiles($request, 'pdf');

        //$pdf = $this->uploadImage($request, 'pdf');

        // Add or update scan
        $scan = new Scan();
        $scan->doctor_id = $request->doctor_id; // Ensure this doctor_id is either coming from authenticated user or safely validated
        $scan->patient_id = $patient->id;

        //add lab id from type of work id
        $type = TypeofWork::findOrFail($request->typeofwork_id);
        $scan->type_id = $request->typeofwork_id;
        $scan->lab_id = $type->lab_id;
        $scan->second_lab_id = $type->second_lab_id;
        $scan->external_lab_id = $type->external_lab_id;
        //
        $scan->due_date = $request->due_date;
        $scan->stl_upper = $upperPath;
        $scan->stl_lower = $lowerPath;
        $scan->pdf = json_encode($pdfPaths);
        $scan->scan_date = now();
        //$scan->note = $request->note;
        $scan->save();

        // Create a new status update for the scan
        $statusUpdate = new Status([
            'scan_id' => $scan->id,
            'status' => 'new', // Setting the initial status to 'pending'
            'note' => $request->note, // Assuming the note comes from the request
            'updated_by' => Auth::id(), // Assuming the current user made this update
        ]);

        $statusUpdate->save();

        // Send Email
        $lab = User::findorFail($type->lab_id);
        $content = [
            'doctorName' => 'Dr. ' . Auth::user()->last_name,
            'dueDate' => $scan->due_date->format('d-m-y'),
            'scanDate' => now()->format('d-m-y'),
            'patientName' => $scan->patient->first_name,
            'labName' => $lab->first_name,
            'scanId' => $scan->id,
            'doctor_scan_url' => route('doctor.scans.index'),
            'lab_scan_url' => route('lab.scans.viewer', ['id' => $scan->id]),
            'scan_due_date' => $scan->due_date->addDays($type->lab_due_date)->format('d-m-y'),
            // Include other data as needed
        ];

        try {
            Mail::to(Auth::user()->email)->send(new ScanCreated($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name)); //$content, 'custom@example.com', 'Custom Name'
            Mail::to($lab->email)->send(new ScanCreatedToLab($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name)); //$content, 'custom@example.com', 'Custom Name'
        } catch (\Exception $e) {
            toastr()->warning($e->getMessage());
        }

        // Mail::to($lab->email)->send(new ScanCreated($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name)); //$content, 'custom@example.com', 'Custom Name'

        //send Notification
        $notification = new Notification();
        $notification->sender_id = Auth::user()->id;
        $notification->receiver_id = $lab->id;
        $notification->message = 'New Scan Created';
        $notification->scan_id = $scan->id;
        $notification->save();

        toastr()->success(trans('messages.scan_created_successfully'));
        return to_route('doctor.scans.index');
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
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Find the scan by ID
            $scan = Scan::findOrFail($id);

            // Upload upper and lower images
            $upperPath = $this->uploadImage($request, 'stl_upper', $scan->upperPath);
            $lowerPath = $this->uploadImage($request, 'stl_lower', $scan->lowerPath);

            // Decode existing PDF paths into an array
            $existingPdfPaths = json_decode($scan->pdf, true) ?? [];

            // Use uploadFiles to handle multiple file uploads for 'pdf'
            // This returns an array of new paths or NULL if no files were uploaded
            $newPdfPaths = $this->uploadFiles($request, 'pdf');

            // If there are new paths, merge them with the existing paths
            if (!is_null($newPdfPaths)) {
                $updatedPdfPaths = array_merge($existingPdfPaths, $newPdfPaths);
                $scan->pdf = json_encode($updatedPdfPaths); // Save the merged paths
            }

            // Update scan details
            $type = TypeofWork::findOrFail($request->typeofwork_id);
            $scan->type_id = $request->typeofwork_id;
            $scan->lab_id = $type->lab_id;
            $scan->second_lab_id = $type->second_lab_id;
            $scan->external_lab_id = $type->external_lab_id;

            $scan->due_date = \Carbon\Carbon::createFromFormat('Y-m-d', $request->due_date);
            $scan->stl_upper = !empty($upperPath) ? $upperPath : $scan->stl_upper;
            $scan->stl_lower = !empty($lowerPath) ? $lowerPath : $scan->lowerPath;

            // Save the scan
            $scan->save();

            // Create a new status update for the scan
            $statusUpdate = new Status([
                'scan_id' => $scan->id,
                'status' => 'pending', // Setting the initial status to 'pending'
                'note' => $request->note, // Assuming the note comes from the request
                'updated_by' => Auth::id(), // Assuming the current user made this update
            ]);
            $statusUpdate->save();

            // Send Email
            $lab = User::findOrFail($type->lab_id);

            $content = [
                'doctorName' => 'Dr. ' . Auth::user()->last_name,
                'dueDate' => $scan->due_date->format('d-m-y'),
                'scanDate' => now()->format('d-m-y'),
                // Include other data as needed
            ];
            Mail::to($lab->email)->send(new ScanCreated($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name)); //$content, 'custom@example.com', 'Custom Name'

            // Send Notification
            $notification = new Notification();
            $notification->sender_id = Auth::user()->id;
            $notification->receiver_id = $lab->id;
            $notification->message = 'test';
            $notification->scan_id = $scan->id;
            $notification->save();

            toastr()->success(trans('messages.scan_updated_successfully'));
            return redirect()->route('doctor.scans.index');
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., ModelNotFoundException)
            toastr()->error('Failed to update scan: ' . $e->getMessage());
            return back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
