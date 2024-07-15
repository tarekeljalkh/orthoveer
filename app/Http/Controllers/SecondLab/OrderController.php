<?php

namespace App\Http\Controllers\SecondLab;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Scan;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::all();
        return view('second_lab.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $completedScans = Scan::whereHas('latestStatus', function ($query) {
            $query->where('status', 'completed');
        })
            ->whereDoesntHave('orders', function ($query) {
                $query->whereIn('status', ['pending', 'delivered']);
            })
            ->get();

        return view('second_lab.orders.create', compact('completedScans'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'scans' => 'required|array',
            'scans.*' => 'exists:scans,id',
        ]);

        DB::beginTransaction();
        try {
            // Attach scans to the order and collect scan details
            $scanDetails = [];
            $orders = [];
            foreach ($validated['scans'] as $scanId) {
                // Check if the scan is already ordered
                $existingOrder = Order::where('scan_id', $scanId)
                    ->whereIn('status', ['pending', 'delivered'])
                    ->first();

                if ($existingOrder) {
                    return back()->with('error', 'One or more scans are already ordered.');
                }

                // Create the order
                $order = new Order();
                $order->lab_id = $request->user()->id;
                $order->scan_id = $scanId;
                $order->status = 'pending';
                $order->save();

                $orders[] = $order;

                $scan = Scan::find($scanId);
                $scanDetails[] = $this->extractScanDetails($scan, $order);
            }

            // Generate the CSV file
            $csvPath = $this->generateCSV($orders, $scanDetails);

            // Attempt to upload the CSV to the FTP server
            if ($this->uploadCSV($csvPath)) {
                foreach ($orders as $order) {
                    $order->status = 'delivered';
                    $order->save();

                    // Create a new status update for the scan
                    $statusUpdate = new Status([
                        'scan_id' => $order->scan_id,
                        'status' => 'delivered',
                        'note' => 'Order completed and delivered',
                        'updated_by' => auth()->user()->id,
                    ]);
                    $statusUpdate->save();
                }
                DB::commit();
                return redirect()->route('second_lab.orders.index')->with('success', 'Order placed and CSV uploaded successfully.');
            } else {
                // Remove the generated CSV file if upload fails
                if (file_exists($csvPath)) {
                    unlink($csvPath);
                }
                DB::rollBack();
                return back()->with('error', 'Failed to upload the CSV to the FTP server.');
            }
        } catch (\Exception $e) {
            // Remove the generated CSV file if an error occurs
            if (file_exists($csvPath)) {
                unlink($csvPath);
            }
            DB::rollBack();
            return back()->with('error', 'An error occurred while processing your request: ' . $e->getMessage());
        }
    }


    private function extractScanDetails($scan, $order)
    {
        $doctor = User::find($scan->doctor_id);

        return [
            'Order Number' => $scan->id,
            'Date' => now()->format('d/m/Y'),
            'To Name' => 'ORTHOVEER',
            'Destination Street' => '17 rue du petit Albi',
            'Destination Suburb' => 'Cergy',
            'Destination City' => 'Cergy',
            'Destination Postcode' => '95800',
            'Destination State' => 'Bloc C2 Porte 203',
            'Destination Country' => 'France',
            'Destination Email' => 'orthoveer@gmail.com',
            'Weight' => 0.0, // Placeholder
            'Shipping Method' => 'DHL Express Intl', // Placeholder
            'Reference' => '', // Placeholder
            'SKU' => '', // Placeholder
            'Qty' => 1, // Placeholder
            'Company' => '', // Placeholder
            'Carrier' => 'DHL', // Placeholder
            'Carrier Product Code' => 'WPX', // Placeholder
            'Phone' => '0745556967', // Adding phone number
        ];
    }

    private function generateCSV($order, $scanDetails)
    {
        // Ensuring the uploads directory exists
        $uploadsPath = storage_path('uploads');
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0777, true);
        }

        $filename = "order_" . now()->format('YmdHis') . ".csv";
        $path = $uploadsPath . '/' . $filename;
        $file = fopen($path, 'w'); // Open file for writing

        foreach ($scanDetails as $details) {
            fputcsv($file, $details);
        }

        fclose($file);

        return $path;
    }


    private function uploadCSV($csvPath)
    {
        $disk = Storage::disk('ftp');
        $name = basename($csvPath);

        try {
            $disk->put($name, fopen($csvPath, 'r+'));
            return true; // Indicate success explicitly
        } catch (\Exception $e) {
            Log::error("FTP upload failed for file: $name. Error: " . $e->getMessage());
            return false; // Indicate failure explicitly
        }
    }

    /**
     * Display the specified order.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return view('second_lab.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(string $id)
    {
        // Your code here
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, string $id)
    {
        // Your code here
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(string $id)
    {
        // Your code here
    }
}
