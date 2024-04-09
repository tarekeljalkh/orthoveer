<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Mail\ScanCreated;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Patient;
use App\Models\Scan;
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
        $categories = Category::with('TypeOfWorks')->get();
        return view('doctor.scans.create', compact('patients', 'categories'));
    }

    public function newScan($id)
    {
        $patient = Patient::findOrFail($id);
        $labs = User::where('role', 'lab')->get();
        return view('doctor.patients.new_scan', compact('patient', 'labs'));
    }

    public function newScanStore(Request $request, $id)
    {
        //find patient id
        $patient = Patient::findOrFail($id);

        // Add scan to patient
        $scan = new Scan();
        $scan->doctor_id = $request->doctor_id; // Ensure this doctor_id is either coming from authenticated user or safely validated
        $scan->patient_id = $patient->id;
        $scan->lab_id = $request->lab;
        $scan->due_date = $request->due_date;
        $scan->scan_date = now();
        $scan->note = $request->note;
        $scan->save();

        toastr()->success('Scan Created Successfully');
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
        //

        $scan->due_date = $request->due_date;
        $scan->stl_upper = $upperPath;
        $scan->stl_lower = $lowerPath;
        $scan->pdf = json_encode($pdfPaths);
        $scan->scan_date = now();
        $scan->note = $request->note;
        $scan->save();

        // Send Email
        $lab = User::findorFail($type->lab_id);
        $content = [
            'doctorName' => 'Dr. ' . Auth::user()->last_name,
            'dueDate' => $scan->due_date->format('d-m-y'),
            'scanDate' => now()->format('d-m-y'),
            // Include other data as needed
        ];

        // try {
        //     Mail::to($lab->email)->send(new OrderPlaced($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name));
        // } catch (\Exception $e) {
        //     // Handle email sending failure, log error, etc.
        // }

        Mail::to($lab->email)->send(new ScanCreated($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name)); //$content, 'custom@example.com', 'Custom Name'

        //send Notification
        $notification = new Notification();
        $notification->sender_id = Auth::user()->id;
        $notification->receiver_id = $lab->id;
        $notification->message = 'test';
        $notification->scan_id = $scan->id;
        $notification->save();

        toastr()->success('Scan Created Successfully');
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
        $scan = Scan::findOrFail($id);
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

        // update scan
        $scan->lab_id = $request->lab;
        //$scan->due_date = $request->due_date;
        $scan->stl_upper = !empty($upperPath) ? $upperPath : $scan->stl_upper;
        $scan->stl_lower = !empty($lowerPath) ? $lowerPath : $scan->lowerPath;
        $scan->pdf = !empty($pdfPaths) ? $pdfPaths : $scan->pdf;
        $scan->scan_date = now();
        $scan->note = $request->note;
        $scan->save();


        // Send Email
        $lab = User::findorFail($request->lab);
        $content = [
            'doctorName' => 'Dr. ' . Auth::user()->last_name,
            'dueDate' => $scan->due_date->format('d-m-y'),
            'scanDate' => now()->format('d-m-y'),
            // Include other data as needed
        ];
        Mail::to($lab->email)->send(new ScanCreated($content, Auth::user()->email, 'Dr. ' . Auth::user()->last_name)); //$content, 'custom@example.com', 'Custom Name'

        //send Notification
        $notification = new Notification();
        $notification->sender_id = Auth::user()->id;
        $notification->receiver_id = $lab->id;
        $notification->message = 'test';
        $notification->scan_id = $scan->id;
        $notification->save();

        toastr()->success('Scan Created Successfully');
        return to_route('doctor.scans.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
