<?php

namespace App\Http\Controllers\Admin;

use App\Models\Scan;
use App\Models\User;
use App\Models\Invoice;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index()
    {
        $invoices = Invoice::with(['user'])->get();
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
            'total_amount' => ['required', 'numeric'],
            'status' => ['required', 'in:unpaid,paid,cancelled'],
            'invoice_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        // Create invoice (invoice_number auto-generated in model)
        $invoice = Invoice::create($request->only([
            'user_id',
            'doctor_id',
            'total_amount',
            'status',
            'invoice_date',
            'due_date',
            'payment_method',
            'notes'
        ]));

        // Attach scans to invoice (pivot)
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
            'total_amount' => ['required', 'numeric'],
            'status' => ['required', 'in:unpaid,paid,cancelled'],
            'invoice_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $invoice->update($request->only([
            'user_id',
            'doctor_id',
            'total_amount',
            'status',
            'invoice_date',
            'due_date',
            'payment_method',
            'notes'
        ]));

        // Sync scans (update pivot table)
        $invoice->scans()->sync($request->scans);

        toastr()->success('Invoice Updated Successfully');
        return redirect()->route('admin.invoices.index');
    }

    /**
     * Remove the specified invoice.
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->scans()->detach(); // detach relations
        $invoice->delete();

        toastr()->success('Invoice Deleted Successfully');
        return redirect()->route('admin.invoices.index');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $pdf = PDF::loadView('admin.invoices.pdf', compact('invoice'));
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}
