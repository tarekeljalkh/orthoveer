<!DOCTYPE html>
<html>

<head>
    <title>Case Received from: {{ $content['doctorName'] }}</title>
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
            background: #0056b3;
            /* Change this to match your brand color */
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
            <h1>Case Submission Received</h1>
        </div>
        <div class="email-body">
            <p>Dear {{ $content['labName'] }},</p>
            <p>You Have a New case from: <strong>{{ $content['doctorName'] }}</strong> for the following Patient: <strong> {{ $content['patientName'] }}</strong></p> with following info:<br>
            <p><strong>Scan ID: {{ $content['scanId'] }}</strong></p>
            <a href="{{ $content['lab_scan_url'] }}">See Scan</a>
            <p><strong>DUE DATE: {{ $content['scan_due_date'] }}</strong> </p>
            <p>Regards,</p>
            <p>Orthoveer</p>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} Orthoveer. All rights reserved.
        </div>
    </div>
</body>

</html>
