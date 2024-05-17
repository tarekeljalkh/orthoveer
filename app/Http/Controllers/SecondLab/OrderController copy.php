<?php

namespace App\Http\Controllers\SecondLab;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Scan;
use App\Models\Status;
use App\Services\DHLService;
use Illuminate\Http\Request;
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
        return view('lab.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $completedScans = Scan::whereHas('latestStatus', function ($query) {
            $query->where('status', 'completed');
        })->get();

        return view('lab.orders.create', compact('completedScans'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'status' => 'required|string',
            'date' => 'required|date',
            'to_name' => 'required|string',
            'destination_street' => 'required|string',
            'destination_city' => 'required|string',
            'destination_postcode' => 'required|string',
            'destination_state' => 'required|string',
            'destination_country' => 'required|string',
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
        ]);

        // Store the order
        $order = new Order();
        $order->fill($validated);
        $order->lab_id = $request->user()->id; // Assumes you are using standard Laravel authentication
        $order->save();

        // Generate CSV and upload via FTP
        $csvPath = $this->generateCSV($order);
        $this->uploadCSV($csvPath);

        return redirect()->route('lab.orders.index')->with('success', 'Order created and file uploaded successfully!');
    }

    private function generateCSV($order)
    {
        $headers = [
            'Order Number', 'Date', 'To Name', 'Destination Street', 'Destination Suburb',
            'Destination City', 'Destination Postcode', 'Destination State',
            'Destination Country', 'Destination Email', 'Destination Phone',
            'Item Name', 'Item Price', 'Weight', 'Shipping Method', 'Reference',
            'SKU', 'Qty', 'Company', 'Carrier', 'Carrier Product Code'
        ];

        $filename = "order_{$order->id}.csv";
        $path = public_path("uploads/$filename");
        $file = fopen($path, 'w');
        fputcsv($file, $headers);

        // Assuming each scan corresponds to an "order number" and other details are same for all scans
        foreach ($order->scans as $scan) {
            $data = [
                $scan->id,
                $order->date,
                $order->to_name,
                $order->destination_street,
                $order->destination_suburb,
                $order->destination_city,
                $order->destination_postcode,
                $order->destination_state,
                $order->destination_country,
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
            fputcsv($file, $data);
        }

        fclose($file);

        return $path;
    }


    private function uploadCSV($csvPath)
    {
        $disk = Storage::disk('ftp');
        $name = basename($csvPath);
        $disk->put($name, fopen($csvPath, 'r+'));
    }


    /**
     * Display the specified order.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return view('lab.orders.show', compact('order'));
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
