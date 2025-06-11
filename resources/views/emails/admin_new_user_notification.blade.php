<!DOCTYPE html>
<html>
<body>
    <h1>New User Registration</h1>
    <p>A new user has registered:</p>
    <ul>
        <li>Name: {{ $user->name->value }}</li>
        <li>Email: {{ $user->email->value }}</li>
    </ul>
</body>
</html>
