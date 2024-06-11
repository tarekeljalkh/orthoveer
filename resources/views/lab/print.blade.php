<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prescription</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
        .prescription-container {
            max-width: 800px;
            margin: 20mm auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .prescription-header {
            display: flex;
            justify-content: space-between;
            padding: 20px 0;
        }
        .prescription-header-left,
        .prescription-header-right {
            flex: 1;
        }
        .prescription-header-left {
            text-align: left;
        }
        .prescription-header-right {
            text-align: right;
        }
        .prescription-header-left img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .prescription-body {
            padding: 20px;
            line-height: 1.5;
            color: #333333;
            text-align: left;
        }
        .prescription-footer {
            text-align: center;
            padding: 10px 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="prescription-container">
        <div class="prescription-header">
            <div class="prescription-header-left">
                <img src="{{ public_path('/assets/logo.jpg') }}" alt="Logo" height="75px">
                <p><strong>ORTHOVEER</strong><br>
                17 rue du petit Albi<br>
                95800 Cergy<br>
                Bloc C2 Porte 203<br>
                orthoveer@gmail.com<br>
                0745556967</p>
            </div>
            <div class="prescription-header-right">
                <p><strong>Doctor:</strong><br>
                {{ $scan->doctor->first_name }} {{ $scan->doctor->last_name }}<br>
                {{ $scan->doctor->address }}<br>
                {{ $scan->doctor->email }}<br>
                {{ $scan->doctor->mobile }}</p>
            </div>
        </div>
        <div class="prescription-body">
            <h1>Prescription</h1>
            <p><strong>Patient:</strong> {{ $scan->patient->first_name }} {{ $scan->patient->last_name }}</p>
            <p><strong>Date:</strong> {{ $scan->due_date->format('d/m/Y') }}</p>
            <p><strong>Type Of Work:</strong> {{ $scan->typeofwork->name }}</p>
            <p><strong>Notes:</strong> {{ $scan->latestStatus->note ?? 'No Note' }}</p>
            <p><strong>Delivery Date:</strong>
                {{ \Carbon\Carbon::now()->addDays($scan->typeofwork->lab_due_date)->format('d/m/Y') }}</p>
            <!-- Add more prescription details as needed -->
        </div>
        <div class="prescription-footer">
            &copy; {{ date('Y') }} Orthoveer. All rights reserved.
        </div>
    </div>
</body>
</html>
