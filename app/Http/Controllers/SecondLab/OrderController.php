<?php
namespace App\Http\Controllers\SecondLab;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Scan;
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
                }
                DB::commit();
                return redirect()->route('second_lab.orders.index')->with('success', 'Order placed and CSV uploaded successfully.');
            } else {
                DB::rollBack();
                return back()->with('error', 'Failed to upload the CSV to the FTP server.');
            }
        } catch (\Exception $e) {
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
            'To Name' => $doctor->first_name . ' ' . $doctor->last_name,
            'Destination Street' => $doctor->delivery_street,
            'Destination Suburb' => $doctor->delivery_suburb,
            'Destination City' => $doctor->delivery_city,
            'Destination Postcode' => $doctor->delivery_postcode,
            'Destination State' => $doctor->delivery_state,
            'Destination Country' => $doctor->delivery_country,
            'Destination Email' => $doctor->email,
            'Weight' => 0.0, // Placeholder
            'Shipping Method' => 'DHL Express Intl', // Placeholder
            'Reference' => '', // Placeholder
            'SKU' => '', // Placeholder
            'Qty' => 1, // Placeholder
            'Company' => '', // Placeholder
            'Carrier' => 'DHL', // Placeholder
            'Carrier Product Code' => 'WPX' // Placeholder
        ];
    }

    private function generateCSV($orders, $scanDetails)
    {
        $headers = [
            'Order Number', 'Date', 'To Name', 'Destination Street', 'Destination Suburb',
            'Destination City', 'Destination Postcode', 'Destination State', 'Destination Country',
            'Destination Email', 'Item Name', 'Item Price', 'Weight', 'Shipping Method', 'Reference',
            'SKU', 'Qty', 'Company', 'Carrier', 'Carrier Product Code'
        ];

        // Ensuring the uploads directory exists
        $uploadsPath = storage_path('uploads');
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0777, true);
        }

        $filename = "order_" . now()->format('YmdHis') . ".csv";
        $path = $uploadsPath . '/' . $filename;
        $file = fopen($path, 'w'); // Open file for writing

        fputcsv($file, $headers);

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
