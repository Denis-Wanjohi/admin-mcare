<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; margin: 0;">

<div style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); max-width: 600px; margin: auto; position: relative;">
    <div style="background-image: url('https://img.freepik.com/free-photo/top-view-delicious-orange-slices_23-2149433547.jpg?t=st=1728671897~exp=1728675497~hmac=3de1163c5a327f077b361fd225701285933dcb2062047a5cc0214225f7ed5bb1&w=826'); background-size: cover; position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1;"></div>
    
    <h1 style="color: #007BFF; font-size: 24px; text-align: center;">Your Appointment Has Been <span style="color:green">Confirmed!</span></h1>
    
    <p style="color: #555555;">Dear {{$name}},</p>
    
    <p style="color: #555555;">Thank you for booking an appointment with us! Here are your appointment details:</p>

    <ul style="list-style-type: none; padding-left: 0;">
        <li style="padding: 10px 0;">
            <strong style="color: #333333;">Appointment Date:</strong> {{$date}}
        </li>
        <li style="padding: 10px 0;">
            <strong style="color: #333333;">Appointment Time:</strong> {{$time}}
        </li>
        <li style="padding: 10px 0;">
            <strong style="color: #333333;">Service Requested:</strong> {{$service}}
        </li>
    </ul>

    <p style="color: #555555;">If you have any questions or need to reschedule, feel free to contact us.</p>

    <p style="color: #555555;">Thank you!</p>

    <div style="margin-top: 30px; font-size: 12px; color: #888888; text-align: center;">
        <p>This email was generated automatically. Please do not reply.</p>
        <p>&copy; MeruCare Medical Center</p>
    </div>
</div>

</body>
</html>