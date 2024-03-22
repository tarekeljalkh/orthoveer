<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabController extends Controller
{
    use FileUploadTrait;

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

        //handle Image Upload
        $imagePath = $this->uploadImage($request, 'image');


        $lab = new User();
        $lab->first_name = $request->first_name;
        $lab->last_name = $request->last_name;
        $lab->email = $request->email;
        $lab->mobile = $request->mobile;
        $lab->image = !empty($imagePath) ? $imagePath : 'uploads/avatar.png';
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

    public function updatePassword(Request $request, string $id)
    {
        // Validation
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $lab = User::findOrFail($id);
        $lab->password = bcrypt($request->password);
        $lab->save();

        toastr()->success('Password Updated Successfully');
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
        $lab = User::findOrFail($id);
        return view('admin.labs.edit', compact('lab'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lab = User::findOrFail($id);

        // Validation
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:png,jpg'],
            'first_name' => ['string', 'max:200'],
            'last_name' => ['string', 'max:200'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::user()->id],
            'mobile' => ['required', 'numeric'],
        ]);

        /** Handle image file */
        $imagePath = $this->uploadImage($request, 'image', $lab->image);


        $lab->first_name = $request->first_name;
        $lab->last_name = $request->last_name;
        $lab->email = $request->email;
        $lab->mobile = $request->mobile;
        $lab->image = !empty($imagePath) ? $imagePath : $lab->image;
        $lab->role = 'lab';
        if ($request->verified === 'yes') {
            $lab->email_verified_at = Carbon::now();
        }
        $lab->save();

        toastr()->success('Lab Updated Successfully');
        // Redirect or return a response
        return to_route('admin.labs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
