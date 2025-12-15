<?php
// error.php
// A simple, generic error page for login failures.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Error</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 50px; }
        .container { width: 400px; margin: 0 auto; }
        .error-box { border: 1px solid #dc3545; background-color: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px; }
        a { color: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-box">
            <h2>Authentication Failed</h2>
            <p>The username or password you entered was incorrect. Please try again.</p>
            <p><a href="login.php">Return to Login</a></p>
        </div>
    </div>
</body>
</html>
