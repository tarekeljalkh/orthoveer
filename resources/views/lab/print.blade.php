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
            margin-bottom: 50px;
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
                        <center><img src="{{ asset('assets/logo.png') }}" width="150px"></center>
                        <center><h2>Order ID #{{ $scan->id }}</h2></center>
                    </div>

                    <div class="section-body">
                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="general-info">
                                            <h3>General Info</h3>
                                            <table class="table">
                                                <tr>
                                                    <td><h5><strong>Patient:</strong> {{ $scan->patient->last_name }}, {{ $scan->patient->first_name }} </h5></td>
                                                    <td><h5><strong>Chart #:</strong> -- </h5></td>
                                                </tr>
                                                <tr>
                                                    <td><h5><strong>Doctor:</strong> {{ $scan->doctor->last_name }}, {{ $scan->doctor->first_name }} </h5></td>
                                                    <td><h5><strong>Procedure:</strong> {{ $scan->typeofwork->name }} </h5></td>
                                                </tr>
                                                <tr>
                                                    <td><h5><strong>Practice:</strong> Orthodontie Exclusive </h5></td>
                                                    <td><h5><strong>Type:</strong> -- </h5></td>
                                                </tr>
                                                <tr>
                                                    <td><h5><strong>Ship to Address:</strong> {{ $scan->doctor->address }} </h5></td>
                                                    <td><h5><strong>Status:</strong> {{ $scan->latestStatus->status }} </h5></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="notes">
                                            <h3>Notes</h3>
                                            @foreach ($scan->status as $status)
                                                <h5>{{ $status->updatedBy->last_name }}, {{ $status->updatedBy->first_name }}<br>
                                                {{ \Carbon\Carbon::parse($status->created_at)->format('d/m/Y, H:i') }}<br>
                                                {{ $status->note }}</h5>
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
