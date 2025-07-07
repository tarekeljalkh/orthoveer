<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 0;
            padding: 30px;
            font-size: 14px;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 15px rgba(0, 0, 0, .05);
            background-color: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f86d19;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo {
            max-height: 120px;
        }

        h1 {
            font-weight: 700;
            font-size: 28px;
            color: #f86d19;
            margin: 0;
        }

        .details-table,
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .details-table td {
            padding: 8px 10px;
        }

        .details-table td:first-child {
            font-weight: 700;
            width: 160px;
            color: #555;
        }

        .items-table th {
            background-color: #f86d19;
            color: white;
            font-weight: 700;
            padding: 12px 10px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        .items-table td {
            border-bottom: 1px solid #eee;
            padding: 10px;
        }

        .total-row td {
            font-weight: 700;
            border-top: 2px solid #f86d19;
        }

        .notes {
            font-style: italic;
            color: #777;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            color: #aaa;
            font-size: 12px;
            margin-top: 40px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <center><img src="{{ asset('assets/logo.png') }}" alt="Company Logo" class="logo" /></center>
            <center><h1>Invoice #{{ $invoice->invoice_number }}</h1></center>
        </div>

        <table class="details-table">
            <tr>
                <td>Invoice Date:</td>
                <td>{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') : '-' }}
                </td>
                <td>Due Date:</td>
                <td>{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <td>Created By:</td>
                <td>{{ $invoice->user?->first_name }} {{ $invoice->user?->last_name }}</td>
                <td>Doctor:</td>
                <td>{{ $invoice->doctor?->first_name }} {{ $invoice->doctor?->last_name }}</td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>{{ ucfirst($invoice->status) }}</td>
            </tr>
        </table>

        <h3>Invoice Details</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Amount</td>
                    <td>{{ number_format($invoice->total_amount, 2) }} USD</td>
                </tr>
                <tr>
                    <td>Payment Method</td>
                    <td>{{ $invoice->payment_method ?? '-' }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td>Total Due</td>
                    <td>{{ number_format($invoice->total_amount, 2) }} USD</td>
                </tr>
            </tfoot>
        </table>

        @if ($invoice->notes)
            <div class="notes">
                <strong>Notes:</strong><br>
                {{ $invoice->notes }}
            </div>
        @endif

        @if ($invoice->scans && $invoice->scans->count())
            <h3>Attached Scans</h3>
            <ul>
                @foreach ($invoice->scans as $scan)
                    <li>Scan #{{ $scan->id }} - {{ $scan->created_at->format('d/m/Y') }}</li>
                @endforeach
            </ul>
        @endif

        <div class="footer">
            &copy; {{ date('Y') }} Orthoveer. All rights reserved.
        </div>
    </div>
</body>

</html>
