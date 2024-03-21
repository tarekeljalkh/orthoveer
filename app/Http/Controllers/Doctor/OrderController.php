<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Retrieve the 'status' query parameter from the request, if any
        $status = $request->query('status');

        // Start building the query to get scans for the logged-in doctor
        $ordersQuery = Scan::with('patient')->where('doctor_id', Auth::user()->id);

        // If a status is provided in the query parameters, add a where condition
        if (!empty($status)) {
            $ordersQuery->where('status', $status);
        }

        // Execute the query to get the results
        $orders = $ordersQuery->get();

        // Return the view with the orders (filtered by status if applicable)
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Scan::findOrFail($id);
        $patients = Patient::where('doctor_id', Auth::user()->id)->get();
        $labs = User::where('role', 'lab')->get();
        return view('doctor.orders.edit', compact('order', 'patients', 'labs'));
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
