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
        // Retrieve the authenticated doctor's ID
        $doctorId = Auth::user()->id;

        // Retrieve all scans for the doctor along with their related last status
        $scans = Scan::with(['latestStatus'])
            ->where('doctor_id', $doctorId)
            ->get();

        // Filter scans based on the last status
        $currentOrders = $scans->filter(function ($scan) {
            return optional($scan->latestStatus)->status === 'new';
        })->count();

        $rejectedOrders = $scans->filter(function ($scan) {
            return optional($scan->latestStatus)->status === 'rejected';
        })->count();

        $deliveredOrders = $scans->filter(function ($scan) {
            return optional($scan->latestStatus)->status === 'delivered';
        })->count();


        $totalOrders = $scans->count();
        return view('doctor.dashboard', compact('currentOrders', 'deliveredOrders', 'rejectedOrders'));
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
