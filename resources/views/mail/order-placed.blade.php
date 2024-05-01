<!DOCTYPE html>
<html>
<head>
    <title>Case Submission Confirmation for {{ $content['patientName'] }}</title>
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
            <h1>Case Submission Confirmation</h1>
        </div>
        <div class="email-body">
            <p>Dear {{ $content['doctorName'] }},</p>
            <p>Thank you for submitting the case for <strong>{{ $content['patientName'] }}</strong>. Our team will review it promptly and provide updates as needed.</p>
            <p>Regards,</p>
            <p>Orthoveer</p>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} Orthoveer. All rights reserved.
        </div>
    </div>
</body>
</html>
