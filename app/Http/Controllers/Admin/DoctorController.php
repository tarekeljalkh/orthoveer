<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.doctors.create');
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
            'landline' => ['nullable', 'numeric'],
            'address' => ['required', 'string', 'max:500'],
            'postal_code' => ['nullable', 'string', 'max:200'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $doctor = new User();

        // Check if the request has an image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Store the image
            $imageName = $request->email . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            // Assuming you have an Image model or a user model with an image attribute
            // You can then save the path to the image in the database
            $doctor->image = 'images/' . $imageName;
        }

        // Update other user information
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->last_name;
        $doctor->email = $request->email;
        $doctor->mobile = $request->mobile;
        $doctor->landline = $request->landline;
        $doctor->address = $request->address;
        $doctor->postal_code = $request->postal_code;
        $doctor->role = 'doctor';
        $doctor->password = bcrypt($request->password);
        if ($request->verified === 'yes') {
            $doctor->email_verified_at = Carbon::now();
        }
        $doctor->save();

        toastr()->success('Doctor Added Successfully');
        // Redirect or return a response
        return to_route('admin.doctors.index');
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
        $doctor = User::findOrFail($id);
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $doctor = User::findOrFail($id);

        // Validation
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:png,jpg'],
            'first_name' => ['string', 'max:200'],
            'last_name' => ['string', 'max:200'],
            'email' => ['required', 'email', 'unique:users,email,' . $doctor->id],
            'mobile' => ['required', 'numeric'],
            'landline' => ['nullable', 'numeric'],
            'address' => ['required', 'string', 'max:500'],
            'postal_code' => ['nullable', 'string', 'max:200'],
        ]);


        // Check if the request has an image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Store the image
            $imageName = $request->email . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            // Assuming you have an Image model or a user model with an image attribute
            // You can then save the path to the image in the database
            $doctor->image = 'images/' . $imageName;
        }

        // Update other user information
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->last_name;
        $doctor->email = $request->email;
        $doctor->mobile = $request->mobile;
        $doctor->landline = $request->landline;
        $doctor->address = $request->address;
        $doctor->postal_code = $request->postal_code;
        $doctor->role = 'doctor';
        $doctor->password = bcrypt($request->password);
        if ($request->verified === 'yes') {
            $doctor->email_verified_at = Carbon::now();
        }
        $doctor->save();

        toastr()->success('Doctor Updated Successfully');
        // Redirect or return a response
        return to_route('admin.doctors.index');
    }

    public function updatePassword(Request $request, string $id)
    {
        // Validation
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $doctor = User::findOrFail($id);
        $doctor->password = bcrypt($request->password);
        $doctor->save();

        toastr()->success('Password Updated Successfully');
        // Redirect or return a response
        return to_route('admin.doctors.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
