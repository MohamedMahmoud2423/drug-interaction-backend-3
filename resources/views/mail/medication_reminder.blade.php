<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Medication Reminder</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            color: #4CAF50;
        }
        .content {
            margin-top: 20px;
            line-height: 1.6;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>⏰ Medication Reminder</h2>
        <div class="content">
            {!! $messageContent !!}
        </div>
        <div class="footer">
            You're receiving this email because you set a medication reminder on our system.
        </div>
    </div>
</body>
</html>
