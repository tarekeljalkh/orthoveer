<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\PrintFile;
use App\Models\Scan;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    public function create($id)
    {
        // This should output the scan_id for debugging purposes
        $scan_id = $id;
        return view('lab.printfiles.create', compact('scan_id'));
    }

    public function show($id)
{
    // Logic to retrieve and display a single print file based on its ID
    $printFile = PrintFile::findOrFail($id);

    return view('lab.printfiles.show', compact('printFile'));
}



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:zip',
            'scan_id' => 'required|exists:scans,id',
        ]);

        // Directly handling file upload for debugging purposes
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('print_files', 'public'); // Storing in the 'public' disk

            if ($path) {
                PrintFile::create([
                    'file_path' => $path,
                    'scan_id' => $request->scan_id,
                ]);

                Log::info("File uploaded successfully. Path: " . $path);

                return back()->with('success', 'File uploaded successfully.');
            } else {
                Log::error("File upload failed. Path not returned.");
                return back()->with('error', 'File upload failed.');
            }
        } else {
            Log::error("No file found in the request.");
            return back()->with('error', 'No file found.');
        }
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
            'file' => 'nullable|file|mimes:zip|max:20480', // max size 20MB
        ]);

        $printFile = PrintFile::findOrFail($id);

        if ($request->hasFile('file')) {
            // Delete the old file
            if ($printFile->file_path && file_exists(public_path('storage/' . $printFile->file_path))) {
                unlink(public_path('storage/' . $printFile->file_path));
            }

            // Store the new file
            $path = $request->file('file')->store('print_files', 'public');
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

        // Delete the file from storage
        if ($printFile->file_path && file_exists(public_path('storage/' . $printFile->file_path))) {
            unlink(public_path('storage/' . $printFile->file_path));
        }

        $printFile->delete();

        return redirect()->route('lab.printfiles.index')->with('success', 'Print file deleted successfully.');
    }

    /**
     * Download the specified resource.
     */
    public function download($id)
    {
        $printFile = PrintFile::findOrFail($id);
        $filePath = public_path($printFile->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return back()->with('error', 'File not found.');
    }

    /**
     * Attach scans to a print file.
     */
    public function attachScans(Request $request)
    {
        $request->validate([
            'scan_ids' => 'required|array',
            'scan_ids.*' => 'exists:scans,id',
            'print_file_id' => 'nullable|exists:print_files,id',
            'new_print_file' => 'nullable|file|mimes:zip|max:20480', // max size 20MB
        ]);

        if ($request->hasFile('new_print_file')) {
            $path = $request->file('new_print_file')->store('print_files', 'public');

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
}
