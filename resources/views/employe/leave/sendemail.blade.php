<!DOCTYPE html>
<html>

<head>
    <title>Leave Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #1a2e44;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
        }

        .email-body {
            padding: 20px;
            color: #333333;
        }

        .email-body p {
            line-height: 1.6;
            margin: 0 0 15px;
        }

        .action-form {
            margin-top: 20px;
            text-align: center;
        }

        .action-form form {
            display: inline-block;
            text-align: left;
        }

        .action-form select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 25px;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            text-decoration: none;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(196, 219, 197);
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            margin-top: 30px;
            padding: 15px;
            border-top: 1px solid #e0e0e0;
            background-color: #f9f9f9;
        }

    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            New Leave Request
        </div>
        <div class="email-body">
            <p><strong>Employee: {{$leave['employe']->emp_name}}</strong></p>
            <p><strong>Leave: {{$leave['leavetype']->type_title}}</strong></p>
            <p><strong>Reason: {{$leave['reason']}}</strong> </p>
            <p><strong>Start Date: {{$leave['start_date']->format('d-M-Y')}}</strong></p>
            <p><strong>End Date:</strong> {{ $leave['end_date']->format('d-M-Y') }}</p>
           @if($leave['total_paid'] != 0)

                @if($leave['total_paid'] <= 1) 
                    <td class="text-danger">
                    @if($leave['total_paid'] !== null)
                    <p><strong>Total Paid:</p> {{ $leave['total_paid']}} Day
                    @endif
                    </td>
                    @else
                    <td class="text-danger">
                    <p><strong>Total Paid:</p> {{ $leave['total_paid'] }} Days
                    </td>
                @endif

            @endif

            @if($leave['total_unpaid'] != 0)

                @if($leave['total_unpaid'] <= 1) 
                    <td class="text-danger">
                    @if($leave['total_unpaid'] !== null)
                    <p><strong>Total Paid:</p> {{ $leave['total_unpaid']}} Day
                    @endif
                    </td>
                    @else
                    <td class="text-danger">
                    <p><strong>Total Paid:</p> {{ $leave['total_unpaid'] }} Days
                    </td>
                @endif

            @endif
                <p>Choose an action and submit your response:</p>
                <div class="action-form">

                    <input type="hidden" name="leave_request_id" value="{{ $leave['id'] }}">
                    <select name="action" required>
                        <option class="text-warning" value="1" @if ($leave['status']==1) Selected @endif>
                            Pending</option>
                    </select>
                    <a href="{{url('superadmin/leave/view/'.Crypt::encrypt($leave['id']))}}" class="">Go To Dashboard</a>
                </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Your Company Name. All rights reserved.
        </div>
    </div>
</body>

</html>
