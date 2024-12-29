<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Unread Notifications Report</title>
</head>
<body>
    <h2>Daily Unread Notifications Report</h2>

    @if ($notifications->isEmpty())
        <p>There are no unread notifications older than one day.</p>
    @else
        <p>Below is the list of unread notifications:</p>
        <ul>
            @foreach ($notifications as $notification)
                <li>
                     {{ $notification->message }}<br>
                    <strong>Created At:</strong> {{ $notification->created_at->format('Y-m-d H:i:s') }}<br>
                </li>
            @endforeach
        </ul>
    @endif

    <p>Thank you!</p>
</body>
</html>
