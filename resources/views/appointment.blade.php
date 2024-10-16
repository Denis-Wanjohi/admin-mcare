<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Appointment Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; margin: 0;">

<div style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); max-width: 600px; margin: auto;">
    <h1 style="color: #007BFF; font-size: 24px; border-bottom: 2px solid #007BFF; padding-bottom: 10px; text-align: center;">New Appointment Scheduled</h1>
    
    <p style="color: #555555; font-size: 16px;">Hello,</p>
    
    <p style="color: #555555; font-size: 16px;">A new appointment has been booked with the following details:</p>

    <ul style="list-style-type: none; padding-left: 0;">
        <li style="padding: 5px 0;">
            <strong style="color: #333333;">Client Name:</strong> {{$name}}
        </li>
        <li style="padding: 5px 0;">
            <strong style="color: #333333;">Email:</strong> {{$email}}
        </li>
        <li style="padding: 5px 0;">
            <strong style="color: #333333;">Phone Number:</strong> {{$phone}}
        </li>
        <li style="padding: 5px 0;">
            <strong style="color: #333333;">Residence Area:</strong> {{$residence}}
        </li>
        <li style="padding: 5px 0;">
            <strong style="color: #333333;">Appointment Date:</strong> {{$date}}
        </li>
        <li style="padding: 5px 0;">
            <strong style="color: #333333;">Appointment Time:</strong> {{$time}}
        </li>
        <li style="padding: 5px 0;">
            <strong style="color: #333333;">Service Requested:</strong> {{$service}}
        </li>
    </ul>

    <p style="color: #555555; font-size: 16px;">Please make sure to confirm the appointment with the client.</p>

    <p style="color: #555555; font-size: 16px;">Thank you!</p>

    <div style="margin-top: 30px; font-size: 12px; color: #888888; text-align: center;">
        <p>This email was generated automatically. Please do not reply.</p>
        <p>&copy;  MeruCare Medical Center</p>
    </div>
</div>

</body>
</html>