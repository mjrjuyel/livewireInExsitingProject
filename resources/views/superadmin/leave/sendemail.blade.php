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

         .button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            text-decoration: none;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #3e8e41;
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
            Response From ({{ config('app.name', 'Laravel') }}) by Admin
        </div>
        <div class="email-body">
            <p><strong>Employee: </strong> {{ $data['employe']->emp_name }}</p>
            <p><strong>Reason: </strong> {{ $data['reason'] }} </p>
            <p><strong>Start Date: </strong> {{ $data['start_date']->format('Y-M-d') }}</p>
            <p><strong>End Date: </strong> {{ $data['end_date']->format('Y-M-d') }}</p>
            <p><strong>
              @if($data['total_paid'] != 0)
                @if($data['total_paid'] <= 1) 
                    @if($data['total_paid'] !== null)
                    <p><strong>Total Paid Leave : </strong> {{ $data['total_paid']}} Day</p> 
                    @endif
                    @else
                    <p><strong>Total Paid Leave : </strong> {{ $data['total_paid'] }} Days</p> 
                @endif
            @endif
            @if($data['total_unpaid'] != 0)
                @if($data['total_unpaid'] <= 1) 
                    @if($data['total_unpaid'] !== null)
                    <p><strong>Total Un-Paid Leave : </strong> {{ $data['total_unpaid']}} Day</p> 
                    @endif
                    @else
                    <p><strong>Total Un-Paid Leave : </strong> {{ $data['total_unpaid'] }} Days</p> 
                @endif

            @endif
            </strong></p>
             
            <p><strong>Comments: </strong> {{ $data['comments'] }}</p>


            <div class="action-form">
                <a href="{{url('dashboard/leave/history/'.Crypt::encrypt($data['employe']->id))}}" class="button">Go To Your Dashboard </a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }}
        </div>
    </div>
</body>

</html>
