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
        // $todaysOrders = Scan::where('lab_id', Auth::user()->id)->whereDate('created_at', now()->format('Y-m-d'))->count();
        // $pendingOrders = Scan::where('lab_id', Auth::user()->id)->where('status', 'pending')->count();
        // $totalOrders = Scan::where('lab_id', Auth::user()->id)->count();

        $labId = Auth::user()->id;

        // Assuming each scan directly belongs to a lab and has a status field
        // Retrieve all scans for the lab with any necessary related models loaded
        $scans = Scan::with('latestStatus') // Adjust based on your actual relationship/method to get current status
        ->where('second_lab_id', $labId)
        ->get();

        // Assuming you have an accessor in the Scan model that dynamically gives you the current status
        // Filter scans based on their current status
        //$todaysScans = $scans->where('created_at', '>=', now()->startOfDay())->count();
        $pendingScans = $scans->where('latestStatus.status', 'pending')->count();
        $rejectedScans = $scans->where('latestStatus.status', 'rejected')->count();
        $completedScans = $scans->where('latestStatus.status', 'completed')->count();
        $deliveredScans = $scans->where('latestStatus.status', 'delivered')->count();
        $totalScans = $scans->count();


        return view('second_lab.dashboard', compact('pendingScans', 'rejectedScans', 'completedScans', 'deliveredScans', 'totalScans'));
    }

    function clearNotification() {
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
