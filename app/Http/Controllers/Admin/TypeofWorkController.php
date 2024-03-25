<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        $categories = Category::all();
        return view('admin.typeofworks.create', compact('categories', 'labs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'price' => ['required', 'integer'],
            'lab_id' => ['required', 'integer'],
            'category_id' => ['required', 'integer']
        ]);

        $typeofwork = new TypeofWork();
        $typeofwork->name = $request->name;
        $typeofwork->price = $request->price;
        $typeofwork->lab_id = $request->lab_id;
        $typeofwork->category_id = $request->category_id;
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
        $categories = Category::all();
        $labs = User::where('role', 'lab')->get();
        return view('admin.typeofworks.edit', compact('typeofwork', 'categories', 'labs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'price' => ['required', 'integer'],
            'lab_id' => ['required', 'integer'],
            'category_id' => ['required', 'integer']
        ]);

        $typeofwork = TypeofWork::findOrFail($id);
        $typeofwork->name = $request->name;
        $typeofwork->price = $request->price;
        $typeofwork->lab_id = $request->lab_id;
        $typeofwork->category_id = $request->category_id;
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
