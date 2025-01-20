<!DOCTYPE html>
<html>
<head>
    <title>Daily Report Summary</title>
</head>
<body>
    <h1>Daily Report Summary for {{ $data['date'] }}</h1>
    <p>Total Reports Submitted: {{ $data['totalReports'] }}</p>

    <p>Total Leave submitted :{{ $data['totalLeaves'] }}</p>
    <p>Total Leave Employees Who Sent: {{ $data['totalLeaveEmploye'] }}</p>
</body>
</html>