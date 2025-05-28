<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Scan;
use Illuminate\Http\Request;
use App\Models\TreatmentPlan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TreatmentPlanController extends Controller
{
    public function index()
    {
        $treatmentPlans = TreatmentPlan::with('scan')
            ->where('doctor_id', auth()->id())
            ->latest()
            ->get();
        return view('doctor.treatment_plans.index', compact('treatmentPlans'));
    }

    public function create()
    {
        $scans = Scan::where('doctor_id', auth()->id())->latest()->get();
        return view('doctor.treatment_plans.create', compact('scans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'scan_id' => 'required|exists:scans,id',
            'notes' => 'nullable|string',
            'files.*' => 'required|file|mimes:stl,jpg,jpeg,png,pdf,zip',
        ]);

        $files = [];
        foreach ($request->file('files', []) as $file) {
            $files[] = $file->store('treatment_plans', 'public');
        }

        $scan = \App\Models\Scan::with('typeofwork')->findOrFail($request->scan_id);


        TreatmentPlan::create([
            'scan_id' => $request->scan_id,
            'doctor_id' => auth()->id(),
            'second_lab_id' => $scan->typeofwork?->second_lab_id, // 👈 this is it honey!
            'notes' => $request->notes,
            'uploaded_files' => json_encode($files),
            'status' => 'pending',
        ]);

        return redirect()->route('doctor.treatment-plans.index')->with('success', 'Treatment plan submitted.');
    }

    public function review($id)
    {
        $plan = \App\Models\TreatmentPlan::with('scan')->where('doctor_id', auth()->id())->findOrFail($id);
        return view('doctor.treatment_plans.review', compact('plan'));
    }

    public function accept($id)
    {
        $plan = TreatmentPlan::where('doctor_id', auth()->id())->findOrFail($id);

        if ($plan->status !== 'review') {
            return back()->with('error', 'This plan is not ready for review.');
        }

        $plan->update(['status' => 'approved']);

        return back()->with('success', 'You have approved the treatment plan. Files are now unlocked.');
    }

    public function refuse($id)
    {
        $plan = TreatmentPlan::where('doctor_id', auth()->id())->findOrFail($id);

        if ($plan->status !== 'review') {
            return back()->with('error', 'This plan is not ready for review.');
        }

        // Remove external STL link (or delete files if you store them)
        $plan->update([
            'external_stl_link' => null,
            'status' => 'rejected',
        ]);

        return back()->with('success', 'You have rejected the treatment plan. STL files were deleted.');
    }
}
