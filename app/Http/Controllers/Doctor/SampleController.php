<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Sample;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function pending()
    {
        $cases = Sample::all();
        return view('doctor.samples.pending', compact('cases'));
    }
}
