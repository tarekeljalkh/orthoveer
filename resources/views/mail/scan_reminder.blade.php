<!DOCTYPE html>
<html>
<head>
    <title>Scan Due Reminder for {{ $labType }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: #0056b3; /* Change this to match your brand color */
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
            line-height: 1.5;
            color: #333333;
        }
        .email-footer {
            text-align: center;
            padding: 10px 20px;
            font-size: 12px;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Scan Due Reminder for {{ $scan->id }}</h1>
        </div>
        <div class="email-body">
            <p>Dear Lab,</p>
            <p>This is a reminder that the scan with the following details is due:</p>
            <p><strong>Scan ID:</strong> {{ $scan->id }}<br>
               <strong>Due Date:</strong> {{ $dueDate }}</p>
            <p>Please ensure all necessary preparations are made.</p>
            <p>Regards,</p>
            <p>Your Company Name</p>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} Your Company Name. All rights reserved.
        </div>
    </div>
</body>
</html>
