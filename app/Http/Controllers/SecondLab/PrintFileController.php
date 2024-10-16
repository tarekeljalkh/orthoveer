<?php

namespace App\Http\Controllers\SecondLab;

use App\Http\Controllers\Controller;
use App\Models\PrintFile;
use App\Models\Scan;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrintFileController extends Controller
{
    public function index()
    {
        // Get the authenticated user's ID
        $labId = Auth::user()->id;

        // Retrieve scans that belong to the lab and have a latest status of "completed"
        $scans = Scan::where('second_lab_id', $labId)
            ->whereHas('latestStatus', function ($query) {
                $query->where('status', 'done');
            })
            ->with(['typeofwork', 'printFiles', 'latestStatus'])
            ->get();

        // Debugging the result
        // dd($scans);

        // Pass the scans to the view
        return view('second_lab.printfiles.index', compact('scans'));
    }



    public function download($id)
    {
        $printFile = PrintFile::findOrFail($id);
        $filePath = 'storage/' . $printFile->file_path;  // Ensure this path matches the storage directory structure

        if (file_exists($filePath)) {
            // Create a new status update for the scan
            $statusUpdate = new Status([
                'scan_id' => $printFile->scan_id,
                'status' => 'completed', // Setting the initial status to 'pending'
                'note' => 'Completed', // Assuming the note comes from the request
                'updated_by' => Auth::id(), // Assuming the current user made this update
            ]);

            $statusUpdate->save();

            return response()->download($filePath);
        }

        return back()->with('error', 'File not found.');
    }
}
