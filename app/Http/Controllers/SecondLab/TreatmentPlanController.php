<?php

namespace App\Http\Controllers\SecondLab;

use App\Http\Controllers\Controller;
use App\Models\TreatmentPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TreatmentPlanController extends Controller
{
    public function index()
    {
        $plans = TreatmentPlan::where('second_lab_id', auth()->id())
            ->whereIn('status', ['pending', 'in_progress'])
            ->latest()
            ->get();

        return view('second_lab.treatment_plans.index', compact('plans'));
    }

    public function show($id)
    {
        $plan = TreatmentPlan::where('second_lab_id', auth()->id())->findOrFail($id);
        return view('second_lab.treatment_plans.show', compact('plan'));
    }

    public function submitLink(Request $request, $id)
    {
        $request->validate([
            'external_stl_link' => 'required|url',
        ]);

        $plan = TreatmentPlan::with('doctor')
            ->where('second_lab_id', auth()->id())
            ->findOrFail($id);

        $plan->update([
            'external_stl_link' => $request->external_stl_link,
            'status' => 'review',
        ]);

        // Email the doctor (already done previously)
        if ($plan->doctor && $plan->doctor->email) {
            Mail::to($plan->doctor->email)->send(new \App\Mail\TreatmentPlanReady($plan));
        }

        return redirect()->route('second_lab.treatment-plans.index')->with('success', 'Link submitted.');
    }
}
