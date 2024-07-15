<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Scan;
use App\Models\TypeofWork;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Retrieve the 'status' and 'due_date' query parameters from the request, if any
        $status = $request->query('status');
        $dueDate = $request->query('due_date');

        // Start building the query to get scans for the logged-in doctor
        $ordersQuery = Scan::with(['patient', 'latestStatus'])->where('doctor_id', Auth::user()->id);

        // If a status is provided in the query parameters, filter scans based on latest status attributes
        if (!empty($status)) {
            $ordersQuery->whereHas('latestStatus', function ($query) use ($status) {
                $query->where('status', $status);
            });
        }

        // If a due_date is provided in the query parameters, add a where condition
        if (!empty($dueDate)) {
            $ordersQuery->whereDate('due_date', $dueDate);
        }

        // Execute the query to get the results
        $orders = $ordersQuery->get();

        // Return the view with the orders (filtered by status and due_date if applicable)
        return view('doctor.orders.index', compact('orders'));
    }



    // public function index()
    // {
    //     $orders = Scan::with('patient')->where('doctor_id', Auth::user()->id)->get();
    //     return view('doctor.orders.index', compact('orders'));
    // }

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
        $order = Scan::with('patient', 'status', 'typeofwork')->findOrFail($id);
        $patients = Patient::where('doctor_id', Auth::user()->id)->get();
        $typeofWorks = TypeofWork::all();
        return view('doctor.orders.show', compact('order', 'patients', 'typeofWorks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Scan::findOrFail($id);
        $patients = Patient::where('doctor_id', Auth::user()->id)->get();
        $typeofWorks = TypeofWork::all();
        return view('doctor.orders.edit', compact('order', 'patients', 'typeofWorks'));
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

    public function pending()
    {
        // Start building the query to get scans for the logged-in doctor
        $pendingOrders = Scan::with(['patient', 'latestStatus'])
            ->where('doctor_id', Auth::user()->id)
            // Apply a condition to filter scans based on the latest status
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'pending');
            })
            ->get(); // Fetch the results

        // You can remove the dump and die function unless you specifically want to debug here
        // dd($pendingScans);

        // Return the view with the scans
        return view('doctor.orders.pending', compact('pendingOrders'));
    }

    public function rejected()
    {
        // Start building the query to get scans for the logged-in doctor
        $rejectedOrders = Scan::with(['patient', 'latestStatus'])
            ->where('doctor_id', Auth::user()->id)
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'rejected');
            })->get();

        // Return the view with the orders
        return view('doctor.orders.rejected', compact('rejectedOrders'));
    }

    public function completed()
    {
        // Start building the query to get scans for the logged-in doctor
        $completedOrders = Scan::with(['patient', 'latestStatus'])
            ->where('doctor_id', Auth::user()->id)
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'completed');
            })->get();

        // Return the view with the orders
        return view('doctor.orders.completed', compact('completedOrders'));
    }

    public function delivered()
    {
        // Start building the query to get scans for the logged-in doctor
        $deliveredOrders = Scan::with(['patient', 'latestStatus', 'typeofwork'])
            ->where('doctor_id', Auth::user()->id)
            ->whereHas('orders', function ($query) {
                $query->where('status', 'delivered');
            })
            ->where(function($query) {
                $query->whereNull('payment_status')
                      ->orWhere('payment_status', '!=', 'PAID');
            }) // Exclude paid scans
            ->get();

        // Return the view with the orders
        return view('doctor.orders.delivered', compact('deliveredOrders'));
    }


}
