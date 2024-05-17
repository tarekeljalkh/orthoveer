<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecondLabController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $second_labs = User::where('role', 'second_lab')->get();
        return view('admin.second_labs.index', compact('second_labs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.second_labs.create');
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


        $second_lab = new User();
        $second_lab->first_name = $request->first_name;
        $second_lab->last_name = $request->last_name;
        $second_lab->email = $request->email;
        $second_lab->mobile = $request->mobile;
        $second_lab->image = !empty($imagePath) ? $imagePath : 'uploads/avatar.png';
        $second_lab->role = 'second_lab';
        $second_lab->password = bcrypt($request->password);
        if ($request->verified === 'yes') {
            $second_lab->email_verified_at = Carbon::now();
        }
        $second_lab->save();

        toastr()->success('Second Lab Added Successfully');
        // Redirect or return a response
        return to_route('admin.second_labs.index');
    }

    public function updatePassword(Request $request, string $id)
    {
        // Validation
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $second_lab = User::findOrFail($id);
        $second_lab->password = bcrypt($request->password);
        $second_lab->save();

        toastr()->success('Password Updated Successfully');
        // Redirect or return a response
        return to_route('admin.second_labs.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $second_lab = User::with('labScans')->findOrFail($id);
        return view('admin.second_labs.show', compact('second_lab'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $second_lab = User::findOrFail($id);
        return view('admin.second_labs.edit', compact('second_lab'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $second_lab = User::findOrFail($id);

        // Validation
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:png,jpg'],
            'first_name' => ['string', 'max:200'],
            'last_name' => ['string', 'max:200'],
            'email' => ['required', 'email', 'unique:users,email,'.$second_lab->id],
            'mobile' => ['required', 'numeric'],
        ]);

        /** Handle image file */
        $imagePath = $this->uploadImage($request, 'image', $second_lab->image);


        $second_lab->first_name = $request->first_name;
        $second_lab->last_name = $request->last_name;
        $second_lab->email = $request->email;
        $second_lab->mobile = $request->mobile;
        $second_lab->image = !empty($imagePath) ? $imagePath : $second_lab->image;
        $second_lab->role = 'second_lab';
        if ($request->verified === 'yes') {
            $second_lab->email_verified_at = Carbon::now();
        }
        $second_lab->save();

        toastr()->success('SecondLab Updated Successfully');
        // Redirect or return a response
        return to_route('admin.second_labs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $second_lab = User::findOrFail($id);
            $second_lab->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            //return response(['status' => 'error', 'message' =>  $e->getMessage()]);
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
