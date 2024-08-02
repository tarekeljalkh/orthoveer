<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilePasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use FileUploadTrait;

    function index() : View {
        return view('doctor.profile.index');
    }

    function updateProfile(ProfileUpdateRequest $request) : RedirectResponse {

        $user = Auth::user();

        $imagePath = $this->uploadImage($request, 'image');

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->image = isset($imagePath) ? $imagePath : $user->image;
        $user->license = $request->license;
        $user->mobile = $request->mobile;
        $user->landline = $request->landline;
        $user->address = $request->address;
        $user->postcode = $request->postcode;
        $user->vat = $request->vat;
        $user->siret_number = $request->siret_number;
        $user->save();

        toastr('Updated Successfully!', 'success');

        return redirect()->back();
    }

    function updatePassword(ProfilePasswordUpdateRequest $request) : RedirectResponse {

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        toastr()->success('Password Updated Successfully');

        return redirect()->back();
    }
}
