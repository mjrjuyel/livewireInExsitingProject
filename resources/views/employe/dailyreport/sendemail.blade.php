<!DOCTYPE html>
<html>

<head>
    <title>Daily Report of {{$insert['employe']->emp_name}}</title>
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
            background-color: rgb(26, 46, 27);
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
            New Daily Report From <strong style="color:#4CAF50;">{{$insert['employe']->emp_name}}</strong>
        </div>
        <div class="email-body">
            <p><strong>Employee: {{$insert['employe']->emp_name}}</strong></p>

            <p><strong>Submit Date: {{$insert['submit_date']->format('d-M-Y ')}}</strong></p>
            <p><strong>Created At: {{formatDate($insert['created_at'])}}</strong></p>

            <p><strong>Report Detail: {!! $insert['detail'] !!}</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} All rights reserved.
        </div>
    </div>
</body>

</html>
