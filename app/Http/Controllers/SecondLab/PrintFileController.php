<?php

namespace App\Http\Controllers\SecondLab;

use App\Http\Controllers\Controller;
use App\Models\PrintFile;
use Illuminate\Http\Request;

class PrintFileController extends Controller
{
    public function download($id)
    {
        $printFile = PrintFile::findOrFail($id);
        $filePath = public_path($printFile->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return back()->with('error', 'File not found.');
    }

}
