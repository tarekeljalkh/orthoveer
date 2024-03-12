<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Scan;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $labs = User::where('role', 'lab')->get();
        return view('doctor.scans.create', compact('patients', 'labs'));
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
        $scan->notes = $request->notes;
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
            $patient->save();
        }

        $upperPath = $this->uploadImage($request, 'stl_upper');
        $lowerPath = $this->uploadImage($request, 'stl_lower');

        // Add or update scan
        $scan = new Scan();
        $scan->doctor_id = $request->doctor_id; // Ensure this doctor_id is either coming from authenticated user or safely validated
        $scan->patient_id = $patient->id;
        $scan->lab_id = $request->lab;
        $scan->due_date = $request->due_date;
        $scan->stl_upper = $upperPath;
        $scan->stl_lower = $lowerPath;
        $scan->scan_date = now();
        $scan->notes = $request->notes;
        $scan->save();

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
