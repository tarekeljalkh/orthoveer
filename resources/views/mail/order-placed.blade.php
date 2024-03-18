<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>New Email Received from Orthoveer Dashboard</h1>

    <p>Doctor Name: {{ $content['doctorName'] }}</p>
    <p>Due Date: {{ $content['dueDate'] }}</p>
    <p>Scan Date: {{ $content['scanDate'] }}</p>

</body>
</html>
