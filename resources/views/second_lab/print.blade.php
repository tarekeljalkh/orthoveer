<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Order Details</title>

    <link rel="stylesheet" href="{{ public_path('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ public_path('assets/modules/fontawesome/css/all.min.css') }}">

    <style>
        body {
            font-size: 9px;
        }
        .section-header, .invoice-title, .general-info, .notes, .additional-scans {
            margin-bottom: 10px;
        }
        .table th, .table td {
            padding: 5px;
        }
        .general-info, .notes, .additional-scans {
            padding: 10px;
            box-shadow: none;
        }
        .main-content {
            padding: 10px;
        }
        .notes p {
            word-wrap: break-word;
            word-break: break-all;
            margin-bottom: 5px;
            line-height: 1.5;
        }
        .notes {
            max-width: 100%; /* Ensure the notes section takes the available width */
        }
        .page-break {
            page-break-before: auto;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Order ID #{{ $scan->id }}</h1>
                    </div>

                    <div class="section-body">
                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="general-info">
                                            <h5>General Info</h5>
                                            <table class="table">
                                                <tr>
                                                    <td><strong>Patient:</strong> {{ $scan->patient->last_name }}, {{ $scan->patient->first_name }}</td>
                                                    <td><strong>Chart #:</strong> --</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Doctor:</strong> {{ $scan->doctor->last_name }}, {{ $scan->doctor->first_name }}</td>
                                                    <td><strong>Procedure:</strong> {{ $scan->typeofwork->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Practice:</strong> Orthodontie Exclusive</td>
                                                    <td><strong>Type:</strong> --</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Ship to Address:</strong> {{ $scan->doctor->address }}</td>
                                                    <td><strong>Status:</strong> {{ $scan->latestStatus->status }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="notes">
                                            <h5>Notes</h5>
                                            @foreach ($scan->status as $status)
                                                <p>{{ $status->updatedBy->last_name }}, {{ $status->updatedBy->first_name }}<br>
                                                {{ \Carbon\Carbon::parse($status->created_at)->format('d/m/Y, H:i') }}<br>
                                                {{ $status->note }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="page-break"></div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>

</html>
