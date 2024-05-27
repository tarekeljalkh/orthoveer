<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\PrintFile;
use App\Models\Scan;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrintFileController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labId = Auth::user()->id;
        $scans = Scan::where('lab_id', $labId)->with('printFiles')->get();

        return view('lab.printfiles.index', compact('scans'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $labId = Auth::user()->id;
        $scans = Scan::where('lab_id', $labId)->get();

        return view('lab.printfiles.create', compact('scans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'scan_id' => 'required|exists:scans,id',
            'file' => 'required|file|mimes:zip|max:20480', // max size 20MB
        ]);

        $scanId = $request->scan_id;
        $path = $this->uploadZip($request, 'file', $scanId);

        if ($path) {
            PrintFile::create([
                'scan_id' => $scanId,
                'file' => $path,
            ]);

            return back()->with('success', 'File uploaded successfully.');
        }

        return back()->with('error', 'File upload failed.');
    }

    public function download($id)
    {
        $printFile = PrintFile::findOrFail($id);
        $filePath = public_path($printFile->file);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return back()->with('error', 'File not found.');
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
