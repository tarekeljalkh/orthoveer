<?php

namespace App\Http\Controllers\ExternalLab;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('external_lab.notifications.index');
    }

    public function markAsSeen($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->update(['seen' => 1]);

            // Assuming the 'lab.orders.viewer' route expects a parameter named 'id' that should be the scan_id of the notification.
            // Redirect to the desired route with the notification's scan_id.
            return redirect()->route('lab.scans.viewer', ['id' => $notification->scan_id]);
        }
        return abort(404); // Notification not found
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
