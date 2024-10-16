<?php

namespace App\Http\Controllers\SecondLab;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecondLabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labId = Auth::user()->id;

        // Retrieve all scans assigned to the second lab
        $scans = Scan::with(['latestStatus', 'typeOfWork'])
            ->where('second_lab_id', $labId)
            ->get();

        // Filter scans based on their current status
        $newScans = $scans->where('latestStatus.status', 'done')->count();
        $deliveredScans = $scans->where('latestStatus.status', 'delivered')->count();

        return view('second_lab.dashboard', compact('newScans', 'deliveredScans'));
    }

    function clearNotification()
    {
        $notification = Notification::query()->update(['seen' => 1]);

        toastr()->success('Notification Cleared Successfully!');
        return redirect()->back();
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
