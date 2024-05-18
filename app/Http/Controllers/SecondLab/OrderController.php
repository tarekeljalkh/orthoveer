<?php

namespace App\Http\Controllers\SecondLab;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Scan;
use App\Models\Status;
use App\Services\DHLService;
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
        })->get();

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
            'status' => 'required|string',
            'date' => 'required|date',
            'to_name' => 'required|string',
            'destination_street' => 'required|string',
            'destination_city' => 'required|string',
            'destination_state' => 'required|string',
            'destination_country' => 'required|string',
            'destination_postcode' => 'required|string',
            'destination_email' => 'nullable|email',
            'destination_phone' => 'required|string',
            'item_name' => 'nullable|string',
            'item_price' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'shipping_method' => 'nullable|string',
            'reference' => 'nullable|string',
            'sku' => 'nullable|string',
            'qty' => 'nullable|integer',
            'company' => 'nullable|string',
            'carrier' => 'nullable|string',
            'carrier_product_code' => 'nullable|string',
            // ... add other validation rules as necessary
        ]);



        DB::beginTransaction();
        try {
            // Create the order
            $order = new Order($validated);
            $order->lab_id = $request->user()->id;
            $order->save();

            // Attach scans to the order
            foreach ($validated['scans'] as $scanId) {
                $scan = Scan::find($scanId);
                $scan->order_id = $order->id; // Set the order ID to mark it as used
                $scan->save();
            }


            // Generate the CSV file
            $csvPath = $this->generateCSV($order, $validated['scans']);

            // Attempt to upload the CSV to the FTP server
            if ($this->uploadCSV($csvPath)) {
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

    private function generateCSV($order, $scans)
    {
        $headers = [
            'Order Number', 'Date', 'To Name', 'Destination Street', 'Destination City',
            'Destination State', 'Destination Country', 'Destination Postcode',
            'Destination Email', 'Destination Phone', 'Item Name', 'Item Price',
            'Weight', 'Shipping Method', 'Reference', 'SKU', 'Qty',
            'Company', 'Carrier', 'Carrier Product Code'
        ];

        // Ensuring the uploads directory exists
        $uploadsPath = storage_path('uploads');
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0777, true);
        }

        $filename = "order_{$order->id}.csv";
        $path = $uploadsPath . '/' . $filename;
        $file = fopen($path, 'w'); // Open file for writing

        fputcsv($file, $headers);

        foreach ($scans as $scanId) {
            $row = [
                $scanId,
                $order->date,
                $order->to_name,
                $order->destination_street,
                $order->destination_city,
                $order->destination_state,
                $order->destination_country,
                $order->destination_postcode,
                $order->destination_email,
                $order->destination_phone,
                $order->item_name,
                $order->item_price,
                $order->weight,
                $order->shipping_method,
                $order->reference,
                $order->sku,
                $order->qty,
                $order->company,
                $order->carrier,
                $order->carrier_product_code
            ];
            fputcsv($file, $row);
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
