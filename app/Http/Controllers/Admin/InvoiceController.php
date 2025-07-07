<?php

namespace App\Http\Controllers\Admin;

use App\Models\Scan;
use App\Models\User;
use App\Models\Invoice;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DoctorWorkPrice;
use App\Models\TypeOfWork;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index()
    {
        $invoices = Invoice::with(['user', 'scans.typeOfWork'])->latest()->get();
        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        // Load users (creators), and scans for selects
        $users = User::all();
        $doctors = User::where('role', 'doctor')->get();
        $scans = Scan::all();

        return view('admin.invoices.create', compact('users', 'doctors', 'scans'));
    }

    /**
     * Store a newly created invoice.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'doctor_id' => ['required', 'exists:users,id'],
            'scans' => ['nullable', 'array'],
            'scans.*' => ['exists:scans,id'],
            'status' => ['required', 'in:unpaid,paid,cancelled'],
            'invoice_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'payment_method' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $totalAmount = 0;

        if ($request->filled('scans')) {
            $scans = Scan::with('typeOfWork')->whereIn('id', $request->scans)->get();

            foreach ($scans as $scan) {
                $defaultPrice = $scan->typeOfWork->my_price ?? 0;

                $doctorPrice = DoctorWorkPrice::where('doctor_id', $request->doctor_id)
                    ->where('type_of_work_id', $scan->type_id)
                    ->value('price');

                $price = $doctorPrice ?? $defaultPrice;
                $totalAmount += $price;
            }
        }

        $invoice = Invoice::create([
            'user_id' => $request->user_id,
            'doctor_id' => $request->doctor_id,
            'status' => $request->status,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'total_amount' => $totalAmount, // ✅ important
        ]);

        $invoice->scans()->attach($request->scans);

        toastr()->success('Invoice Created Successfully');
        return redirect()->route('admin.invoices.index');
    }


    /**
     * Display the specified invoice.
     */
    public function show($id)
    {
        $invoice = Invoice::with(['user', 'scans'])->findOrFail($id);
        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing an invoice.
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $users = User::all();
        $doctors = User::where('role', 'doctor')->get();
        $scans = Scan::all();

        // get attached scan IDs for the form
        $selectedScans = $invoice->scans()->pluck('scans.id')->toArray();

        return view('admin.invoices.edit', compact('invoice', 'users', 'doctors', 'scans', 'selectedScans'));
    }

    /**
     * Update the specified invoice.
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'doctor_id' => ['required', 'exists:users,id'],
            'scans' => ['required', 'array'],
            'scans.*' => ['exists:scans,id'],
            'status' => ['required', 'in:unpaid,paid,cancelled'],
            'invoice_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        // Recalculate total amount
        $totalAmount = 0;

        if ($request->filled('scans')) {
            $scans = Scan::with('typeOfWork')->whereIn('id', $request->scans)->get();

            foreach ($scans as $scan) {
                $defaultPrice = $scan->typeOfWork->my_price ?? 0;

                $doctorPrice = DoctorWorkPrice::where('doctor_id', $request->doctor_id)
                    ->where('type_of_work_id', $scan->type_id)
                    ->value('price');

                $price = $doctorPrice ?? $defaultPrice;
                $totalAmount += $price;
            }
        }

        // Update invoice with recalculated total
        $invoice->update([
            'user_id' => $request->user_id,
            'doctor_id' => $request->doctor_id,
            'status' => $request->status,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'total_amount' => $totalAmount,
        ]);

        // Sync scans
        $invoice->scans()->sync($request->scans);

        toastr()->success('Invoice Updated Successfully');
        return redirect()->route('admin.invoices.index');
    }

    /**
     * Remove the specified invoice.
     */
    public function destroy($id)
    {
        try {

            $invoice = Invoice::findOrFail($id);
            $invoice->scans()->detach(); // detach relations
            $invoice->delete();

            toastr()->success('Deleted Successfully');
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            //return response(['status' => 'error', 'message' =>  $e->getMessage()]);
            toastr()->success('Something went wrong');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }


public function calculateTotal(Request $request)
{
    $doctorId = $request->input('doctor_id');
    $scansIds = $request->input('scans', []);

    $total = 0;

    $scans = Scan::with('typeOfWork')->whereIn('id', $scansIds)->get();

    foreach ($scans as $scan) {
        $defaultPrice = $scan->typeOfWork->my_price ?? 0;

        $doctorPrice = DoctorWorkPrice::where('doctor_id', $doctorId)
            ->where('type_of_work_id', $scan->type_id)
            ->value('price');

        $total += $doctorPrice ?? $defaultPrice;
    }

    return response()->json(['total' => $total]);
}

    public function downloadPdf(Invoice $invoice)
    {
        $pdf = PDF::loadView('admin.invoices.pdf', compact('invoice'));
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}
