<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeofWork;
use App\Models\User;
use Illuminate\Http\Request;

class TypeofWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeofworks = TypeofWork::all();
        return view('admin.typeofworks.index', compact('typeofworks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $labs = User::where('role', 'lab')->get();
        $second_labs = User::where('role', 'second_lab')->get();
        $external_labs = User::where('role', 'external_lab')->get();
        return view('admin.typeofworks.create', compact('labs', 'second_labs', 'external_labs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'lab_id' => ['required', 'integer'],
            'second_lab_id' => ['required', 'integer'],
            'external_lab_id' => ['required', 'integer'],
        ]);

        $typeofwork = new TypeofWork();
        $typeofwork->name = $request->name;
        $typeofwork->lab_price = $request->lab_price;
        $typeofwork->bag_coule = $request->bag_coule;
        $typeofwork->my_price = $request->my_price;
        $typeofwork->invoice_to = $request->invoice_to;
        $typeofwork->cash_out = $request->cash_out;
        $typeofwork->my_benefit = $request->my_benefit;
        $typeofwork->accessories = $request->accessories;
        $typeofwork->lab_id = $request->lab_id;
        $typeofwork->lab_due_date = $request->lab_due_date;
        $typeofwork->second_lab_id = $request->second_lab_id;
        $typeofwork->second_lab_due_date = $request->second_lab_due_date;
        $typeofwork->external_lab_id = $request->external_lab_id;
        $typeofwork->external_lab_due_date = $request->external_lab_due_date;
        $typeofwork->save();

        toastr()->success('Type of Work Added Successfully');
        // Redirect or return a response
        return to_route('admin.type-of-works.index');

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
        $typeofwork = TypeofWork::findOrFail($id);
        $labs = User::where('role', 'lab')->get();
        $second_labs = User::where('role', 'second_lab')->get();
        $external_labs = User::where('role', 'external_lab')->get();
        return view('admin.typeofworks.edit', compact('typeofwork', 'labs', 'second_labs', 'external_labs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'lab_id' => ['required', 'integer'],
            'second_lab_id' => ['nullable', 'integer'],
            'external_lab_id' => ['nullable', 'integer'],
        ]);

        $typeofwork = TypeofWork::findOrFail($id);
        $typeofwork->name = $request->name;
        $typeofwork->lab_price = $request->lab_price;
        $typeofwork->bag_coule = $request->bag_coule;
        $typeofwork->my_price = $request->my_price;
        $typeofwork->invoice_to = $request->invoice_to;
        $typeofwork->cash_out = $request->cash_out;
        $typeofwork->my_benefit = $request->my_benefit;
        $typeofwork->accessories = $request->accessories;
        $typeofwork->lab_id = $request->lab_id;
        $typeofwork->lab_due_date = $request->lab_due_date;
        $typeofwork->second_lab_id = $request->second_lab_id;
        $typeofwork->second_lab_due_date = $request->second_lab_due_date;
        //$typeofwork->second_lab_id = $request->input('second_lab_id');  // Get the second lab id, handles null automatically
        $typeofwork->external_lab_id = $request->external_lab_id;
        $typeofwork->external_lab_due_date = $request->external_lab_due_date;
        $typeofwork->save();

        toastr()->success('Type of Work Updated Successfully');
        // Redirect or return a response
        return to_route('admin.type-of-works.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $typeofwork = TypeofWork::findOrFail($id);
            $typeofwork->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            //return response(['status' => 'error', 'message' =>  $e->getMessage()]);
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
