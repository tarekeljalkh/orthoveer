<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::where('doctor_id', Auth::user()->id)->get();
        return view('doctor.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctor.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'max:150'],
            'last_name' => ['required', 'max:150'],
            'dob' => ['required', 'date'],
            'gender' => ['required'],
            'doctor_id' => ['required', 'numeric'],
        ]);

        $patient = new Patient();
        $patient->first_name = $request->first_name;
        $patient->last_name = $request->last_name;
        $patient->dob = $request->dob;
        $patient->gender = $request->gender;
        $patient->chart_number = $request->chart_number;
        $patient->doctor_id = $request->doctor_id;
        $patient->save();

        toastr()->success('Patient has been Added successfully!', 'Congrats', ['timeOut' => 3000]);
        return to_route('doctor.patients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('doctor.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('doctor.patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => ['required', 'max:150'],
            'last_name' => ['required', 'max:150'],
            'dob' => ['required', 'date'],
            'gender' => ['required'],
            'doctor_id' => ['required', 'numeric'],
        ]);

        $patient = Patient::findOrFail($id);
        $patient->first_name = $request->first_name;
        $patient->last_name = $request->last_name;
        $patient->dob = $request->dob;
        $patient->gender = $request->gender;
        $patient->chart_number = $request->chart_number;
        $patient->doctor_id = $request->doctor_id;
        $patient->save();

        toastr()->success('Patient has been Updated successfully!', 'Congrats', ['timeOut' => 3000]);
        return to_route('doctor.patients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
