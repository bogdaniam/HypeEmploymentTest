<?php
// dashboard.php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

// Fetch all registered users from the database
// In a real-world app, you'd want to paginate this data.
try {
    $stmt = $pdo->query("SELECT id, username, email, created_at FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll();
} catch (\PDOException $e) {
    // Handle potential database errors
    die("Error fetching users: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; }
        .container { width: 800px; margin: 50px auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn-logout { padding: 8px 12px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!--
                Sanitizing user output with htmlspecialchars to prevent XSS.
                It's good practice to always escape output, even if it comes from a "trusted" source like the session.
            -->
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>!</h1>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>

        <h2>Registered Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <!-- Sanitizing all data fetched from the DB before displaying it -->
                        <td><?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($user['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
