<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prescription</title>
    <style>
        @page {
            margin: 20mm;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Prescription for {{ $scan->patient->first_name }} {{ $scan->patient->last_name }}</h1>
    <p>Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    <p>Doctor: {{ $scan->doctor->first_name }} {{ $scan->doctor->last_name }}</p>
    <p>Procedure: {{ $scan->typeofwork->name }}</p>
    <p>Status: {{ $scan->latestStatus->status ?? 'No status' }}</p>
    <!-- Add more prescription details as needed -->
</body>
</html>
