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
        // $currentOrders = Scan::where('doctor_id', Auth::user()->id)->where('status', 'completed')->count();
        // $pendingOrders = Scan::where('doctor_id', Auth::user()->id)->where('status', 'pending')->count();
        // $totalOrders = Scan::where('doctor_id', Auth::user()->id)->count();
        // $rejectedOrders = Scan::where('doctor_id', Auth::user()->id)->where('status', 'rejected')->count();

        $doctorId = Auth::user()->id;

        // Retrieve all scans for the doctor
        $scans = Scan::with(['status'])
                     ->where('doctor_id', $doctorId)
                     ->get();

        // Filter based on the current status accessor
        $currentOrders = $scans->where('current_status', 'completed')->count();
        $pendingOrders = $scans->where('current_status', 'pending')->count();
        $rejectedOrders = $scans->where('current_status', 'rejected')->count();
        $totalOrders = $scans->count();



        return view('doctor.dashboard', compact('currentOrders', 'pendingOrders', 'totalOrders', 'rejectedOrders'));
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
