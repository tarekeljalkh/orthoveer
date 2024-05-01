<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExternalLabController extends Controller
{

    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $external_labs = User::where('role', 'external_lab')->get();
        return view('admin.external_labs.index', compact('external_labs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.external_labs.create');
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


        $external_lab = new User();
        $external_lab->first_name = $request->first_name;
        $external_lab->last_name = $request->last_name;
        $external_lab->email = $request->email;
        $external_lab->mobile = $request->mobile;
        $external_lab->image = !empty($imagePath) ? $imagePath : 'uploads/avatar.png';
        $external_lab->role = 'external_lab';
        $external_lab->password = bcrypt($request->password);
        if ($request->verified === 'yes') {
            $external_lab->email_verified_at = Carbon::now();
        }
        $external_lab->save();

        toastr()->success('External Lab Added Successfully');
        // Redirect or return a response
        return to_route('admin.external_labs.index');
    }


    public function updatePassword(Request $request, string $id)
    {
        // Validation
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $external_lab = User::findOrFail($id);
        $external_lab->password = bcrypt($request->password);
        $external_lab->save();

        toastr()->success('Password Updated Successfully');
        // Redirect or return a response
        return to_route('admin.external_labs.index');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $external_lab = User::with('externalLabScans')->findOrFail($id);
        return view('admin.external_labs.show', compact('external_lab'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $external_lab = User::findOrFail($id);
        return view('admin.external_labs.edit', compact('external_lab'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $external_lab = User::findOrFail($id);

        // Validation
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:png,jpg'],
            'first_name' => ['string', 'max:200'],
            'last_name' => ['string', 'max:200'],
            'email' => ['required', 'email', 'unique:users,email,'.$external_lab->id],
            'mobile' => ['required', 'numeric'],
        ]);

        /** Handle image file */
        $imagePath = $this->uploadImage($request, 'image', $external_lab->image);


        $external_lab->first_name = $request->first_name;
        $external_lab->last_name = $request->last_name;
        $external_lab->email = $request->email;
        $external_lab->mobile = $request->mobile;
        $external_lab->image = !empty($imagePath) ? $imagePath : $external_lab->image;
        $external_lab->role = 'external_lab';
        if ($request->verified === 'yes') {
            $external_lab->email_verified_at = Carbon::now();
        }
        $external_lab->save();

        toastr()->success('External Lab Updated Successfully');
        // Redirect or return a response
        return to_route('admin.external_labs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $external_lab = User::findOrFail($id);
            $external_lab->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            //return response(['status' => 'error', 'message' =>  $e->getMessage()]);
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
