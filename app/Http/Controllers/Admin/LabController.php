<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labs = User::where('role', 'lab')->get();
        return view('admin.labs.index', compact('labs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.labs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:png,jpg'],
            'first_name' => ['string', 'max:200'],
            'last_name' => ['string', 'max:200'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::user()->id],
            'mobile' => ['required', 'numeric'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $lab = new User();

        // Check if the request has an image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Store the image
            $imageName = $request->email . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            // Assuming you have an Image model or a user model with an image attribute
            // You can then save the path to the image in the database
            $lab->image = 'images/' . $imageName;
        }

        // Update other user information
        $lab->first_name = $request->first_name;
        $lab->last_name = $request->last_name;
        $lab->email = $request->email;
        $lab->mobile = $request->mobile;
        $lab->role = 'lab';
        $lab->password = bcrypt($request->password);
        if ($request->verified === 'yes') {
            $lab->email_verified_at = Carbon::now();
        }
        $lab->save();

        toastr()->success('Lab Added Successfully');
        // Redirect or return a response
        return to_route('admin.labs.index');
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
