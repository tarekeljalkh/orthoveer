<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    use FileUploadTrait;
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

        //handle Image Upload
        $imagePath = $this->uploadImage($request, 'image');

        $doctor = new User();
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->last_name;
        $doctor->email = $request->email;
        $doctor->image = $imagePath;
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
        dd($id);
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
            'first_name' => ['string', 'max:200'],
            'last_name' => ['string', 'max:200'],
            'email' => ['required', 'email', 'unique:users,email,' . $doctor->id],
            'mobile' => ['required', 'numeric'],
            'landline' => ['nullable', 'numeric'],
            'address' => ['required', 'string', 'max:500'],
            'postal_code' => ['nullable', 'string', 'max:200'],
        ]);

        /** Handle image file */
        $imagePath = $this->uploadImage($request, 'image', $doctor->image);

        // Update other user information
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->last_name;
        $doctor->email = $request->email;
        $doctor->image = !empty($imagePath) ? $imagePath : $doctor->image;
        $doctor->mobile = $request->mobile;
        $doctor->landline = $request->landline;
        $doctor->address = $request->address;
        $doctor->postal_code = $request->postal_code;
        $doctor->role = 'doctor';
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
        // try {
        //     $slider = BannerSlider::findOrFail($id);
        //     $this->removeImage($slider->banner);
        //     $slider->delete();
        //     return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        // } catch (\Exception $e) {
        //     return response(['status' => 'error', 'message' => 'something went wrong!']);
        // }

    }
}
