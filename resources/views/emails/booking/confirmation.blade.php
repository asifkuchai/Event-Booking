<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { background: #fff; padding: 20px; border-radius: 8px; }
        .btn {
            display: inline-block;
            background: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎉 Booking Confirmed</h2>
        <p>Hello <strong>{{ $booking->user->name }}</strong>,</p>
        <p>Your booking for <strong>{{ $booking->event->title }}</strong> is confirmed.</p>

        <p>
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->event->event_date)->format('F j, Y g:i A') }}<br>
            <strong>Venue:</strong> {{ $booking->event->venue }}<br>
            <strong>Tickets:</strong> {{ $booking->tickets }}
        </p>

        <p>Thanks,<br>Event Booking System</p>
    </div>
</body>
</html>
