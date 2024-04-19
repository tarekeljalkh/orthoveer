<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Scan;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return view('lab.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch scans where the latest status is 'completed'
        $completedScans = Scan::whereHas('latestStatus', function($query) {
            $query->where('status', 'completed');
        })->get();

        return view('lab.orders.create', compact('completedScans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'scans' => 'required|array',
            'scans.*' => 'exists:scans,id',
            'tracking_number' => 'required|string|max:255',
        ]);

        $order = new Order();
        $order->dhl_tracking_number = $request->tracking_number;
        $order->save();

        //$order->scans()->attach($request->scans); // Assuming you have set up the many-to-many relationship
        // Attach selected scans to the order
        $order->scans()->attach($request->scan_ids);

        // Handle DHL integration here if necessary

        toastr()->success('Order Created Successfully');
        return redirect()->route('orders.index')->with('success', 'Order created successfully!');

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
