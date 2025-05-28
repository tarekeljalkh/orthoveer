<!DOCTYPE html>
<html>
<head>
    <title>Treatment Plan Ready</title>
</head>
<body>
    <p>Hello Dr. {{ $plan->doctor->first_name }},</p>

    <p>A new treatment plan is ready for your review for Scan #{{ $plan->scan_id }}.</p>

    <p>
        <strong>STL Link:</strong><br>
        <a href="{{ $plan->external_stl_link }}">{{ $plan->external_stl_link }}</a>
    </p>

    <p>Please log in to approve or reject this plan.</p>

    <p>Regards,<br>Orthoveer System</p>
</body>
</html>
