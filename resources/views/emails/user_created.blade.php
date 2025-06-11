<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Our App</title>
</head>
<body>
    <h1>Welcome, {{ $user->name->value }}!</h1>

    <p>Thank you for registering with us. Your account has been successfully created.</p>

    <p>Here are your details:</p>
    <ul>
        <li>Name: {{ $user->name->value }}</li>
        <li>Email: {{ $user->email->value }}</li>
    </ul>

    <p>We're excited to have you on board 🎉</p>

    <p>Best regards,<br>The {{ config('app.name') }} Team</p>
</body>
</html>
