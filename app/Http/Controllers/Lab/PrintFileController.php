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
        $printFiles = PrintFile::all();

        return view('lab.printfiles.index', compact('scans', 'printFiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lab.printfiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:zip|max:20480', // max size 20MB
        ]);

        $path = $this->uploadZip($request, 'file', 'print_files');

        if ($path) {
            PrintFile::create([
                'file_path' => $path,
            ]);

            return back()->with('success', 'File uploaded successfully.');
        }

        return back()->with('error', 'File upload failed.');
    }

    public function download($id)
    {
        $printFile = PrintFile::findOrFail($id);
        $filePath = public_path($printFile->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return back()->with('error', 'File not found.');
    }

    public function attachScans(Request $request)
    {
        $request->validate([
            'scan_ids' => 'required|array',
            'scan_ids.*' => 'exists:scans,id',
            'print_file_id' => 'nullable|exists:print_files,id',
            'new_print_file' => 'nullable|file|mimes:zip|max:20480', // max size 20MB
        ]);

        if ($request->hasFile('new_print_file')) {
            $path = $this->uploadZip($request, 'new_print_file', 'print_files');

            if ($path) {
                $printFile = PrintFile::create([
                    'file_path' => $path,
                ]);
            } else {
                return back()->with('error', 'File upload failed.');
            }
        } else {
            $printFile = PrintFile::findOrFail($request->print_file_id);
        }

        $printFile->scans()->syncWithoutDetaching($request->scan_ids);

        return redirect()->back()->with('success', 'Scans attached to print file successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $printFile = PrintFile::findOrFail($id);
        return view('lab.printfiles.edit', compact('printFile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'file' => 'file|mimes:zip|max:20480', // max size 20MB
        ]);

        $printFile = PrintFile::findOrFail($id);

        if ($request->hasFile('file')) {
            $path = $this->uploadZip($request, 'file', 'print_files');
            $printFile->file_path = $path;
        }

        $printFile->save();

        return redirect()->route('lab.printfiles.index')->with('success', 'Print file updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $printFile = PrintFile::findOrFail($id);
        $printFile->delete();

        return redirect()->route('lab.printfiles.index')->with('success', 'Print file deleted successfully.');
    }
}
