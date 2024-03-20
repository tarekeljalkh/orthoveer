<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Scan;
use App\Models\ScanCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todaysOrders = Scan::where('lab_id', Auth::user()->id)->whereDate('created_at', now()->format('Y-m-d'))->count();
        $pendingOrders = Scan::where('lab_id', Auth::user()->id)->where('status', 'pending')->count();
        $totalOrders = Scan::where('lab_id', Auth::user()->id)->count();

        return view('lab.dashboard', compact('todaysOrders', 'pendingOrders', 'totalOrders'));
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
