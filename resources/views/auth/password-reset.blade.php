<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
<h1>Reset Your Password</h1>
<p>Click the link below to reset your password:</p>
@if(isset($resetUrl))
    <a href="{{ $resetUrl }}">Reset Password</a>
@else
    <p>Reset link not available.</p>
@endif
<p>If you did not request this, please ignore this email.</p>
</body>
</html>
