<?php

namespace App\Http\Controllers\Lab;

use App\Events\ScanCreateEvent;
use App\Http\Controllers\Controller;
use App\Mail\scanRejected;
use App\Models\Notification;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Scan::with('doctor')->where('lab_id', Auth::user()->id)->get();
        return view('lab.orders.index', compact('orders'));
    }

    public function pending()
    {
        $orders = Scan::with('doctor')->where('lab_id', Auth::user()->id)->where('status', 'pending')->get();
        return view('lab.orders.pending', compact('orders'));
    }

    public function new()
    {
        $orders = Scan::with('doctor')->where('lab_id', Auth::user()->id)->whereMonth('created_at', now()->month)->where('status', '!=', 'rejected')->get();
        return view('lab.orders.new', compact('orders'));
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_note' => ['required', 'max:200']
        ]);

        $scan = Scan::findOrFail($id);
        $scan->status = 'rejected';
        $scan->note = $request->reject_note;
        $scan->save();


        // Send Email
        $doctor = User::findOrFail($scan->doctor_id);
        $content = [
            'lab' => 'Lab. ' . Auth::user()->first_name,
            'note' => $scan->note,
            // Include other data as needed
        ];
        Mail::to($doctor->email)->send(new scanRejected($content, Auth::user()->email, 'Lab. ' . Auth::user()->first_name)); //$content, 'custom@example.com', 'Custom Name'

        //send Notification
        $notification = new Notification();
        $notification->sender_id = Auth::user()->id;
        $notification->receiver_id = $doctor->id;
        $notification->message = $scan->note;
        $notification->scan_id = $scan->id;
        $notification->save();

        toastr()->success('Scan Returned to Doctor Successfully!');

        return to_route('lab.orders.pending');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function viewer($id)
    {
        //$order = Scan::findOrFail($id);
        $order = Scan::with('comments')->findOrFail($id);
        return view('lab.viewer.index', compact('order'));
    }

    public function prescription($id)
    {
        //$order = Scan::findOrFail($id);
        $order = Scan::with('comments')->findOrFail($id);
        return view('lab.prescription.index', compact('order'));
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
