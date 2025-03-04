<!DOCTYPE html>
<html>
<head>
    <title>Daily Report Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .content {
            margin-top: 20px;
        }
        .content p {
            font-size: 16px;
            margin: 10px 0;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .highlight {
            font-weight: bold;
            color: #2c3e50;
        }
        .content-item {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 4px solid #0073e6;
            border-radius: 4px;
        }
        .label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 4px;
        }
        .value {
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Daily Summary of {{config('app.name','Laravel')}} </h1>
            <p>Date: <span class="highlight">{{ now()->format('d-M-Y') }}(Today)</span></p>
        </div>

        <div class="content">
            <div class="content-item">
                <span class="label">Total Reports Submitted Today</span>
                <span class="value highlight">{{ $data['totalReports'] }}</span>
            </div>
            {{-- <div class="content-item">
                <span class="label">Total Employee Who Submitted Reports (Employee Count)</span>
                <span class="value highlight">{{ $data['totalEmployees'] }}</span>
            </div> --}}
            <div class="content-item">
                <span class="label">Total Leaves Request Submitted Today</span>
                <span class="value highlight">{{ $data['totalLeaves'] }}</span>
            </div>
            {{-- <div class="content-item">
                <span class="label">How Many Employee Sent Leave Request Today ?</span>
                <span class="value highlight">{{ $data['totalLeaveEmploye'] }}</span>
            </div> --}}
        </div>

        <div class="content">
            <div class="content-item">
                <span class="label">Today's Total Meal Quantity : </span>
                <span class="value highlight">{{ $data['total_order'] }}</span>
            </div>
            <div class="content-item">
                <span class="label">today's Total Cost Of Meal</span>
                <span class="value highlight">{{currencyChange()}} {{ $data['total_cost'] }}</span>
            </div>
            <div class="content-item">
                <span class="label">Today's Payment in Catering?</span>
                <span class="value highlight">{{currencyChange()}} {{ $data['today_payment'] }}</span>
            </div>

            <div class="content-item">
                <span class="label">Total Due In This Month For The Catering</span>
                <span class="value highlight">{{currencyChange()}} {{ $data['total_due'] }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for reviewing the daily summary.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

