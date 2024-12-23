<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body>
<p>Welcome {{ $user->name }}!</p>
<p>Please enter the following code to verify your email address:</p>
<p><strong>{{ $verificationToken }}</strong></p>
<p>This code will expire in 1 hour.</p>
</body>
</html>
