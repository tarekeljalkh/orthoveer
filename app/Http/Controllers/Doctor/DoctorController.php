<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentScans = Scan::where('doctor_id', Auth::user()->id)->where('status', 'completed')->count();
        $pendingScans = Scan::where('doctor_id', Auth::user()->id)->where('status', 'pending')->count();
        $totalScans = Scan::where('doctor_id', Auth::user()->id)->count();
        $rejectedScans = Scan::where('doctor_id', Auth::user()->id)->where('status', 'rejected')->count();

        return view('doctor.dashboard', compact('currentScans', 'pendingScans', 'totalScans', 'rejectedScans'));
    }

    function clearNotification()
    {
        $notification = Notification::query()->update(['seen' => 1]);

        toastr()->success('Notification Cleared Successfully!');
        return redirect()->back();
    }


    public function pending()
    {
        return view('doctor.cas.pending');
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
