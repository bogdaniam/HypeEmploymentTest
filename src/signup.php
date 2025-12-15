<?php
// signup.php
session_start();
require_once 'db.php';

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. CSRF Token Validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors[] = 'Invalid CSRF token.';
    } else {
        // 2. Input Sanitization and Validation
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        // Validate username (simple example: alphanumeric, 3-20 chars)
        if (!preg_match('/^[a-zA-Z0-9]{3,20}$/', $username)) {
            $errors[] = 'Username must be 3-20 alphanumeric characters.';
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address.';
        }

        // Validate password
        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long.';
        } elseif ($password !== $password_confirm) {
            $errors[] = 'Passwords do not match.';
        }

        // Check if username or email already exists
        if (empty($errors)) {
            $stmt = $pdo->prepare("SELECT 1 FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                $errors[] = 'Username or email already taken.';
            }
        }

        // If no errors, insert user into database
        if (empty($errors)) {
            // 3. Secure Password Hashing
            $hashed_password = password_hash($password, PASSWORD_ARGON2ID);

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashed_password])) {
                // Redirect to login page after successful registration
                header("Location: login.php");
                exit;
            } else {
                $errors[] = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <style>
        body { font-family: sans-serif; }
        .container { width: 300px; margin: 50px auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 8px; }
        .btn { padding: 10px 15px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        .errors { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>

        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); // 4. XSS Prevention ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="signup.php" method="post">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirm Password</label>
                <input type="password" name="password_confirm" id="password_confirm" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
