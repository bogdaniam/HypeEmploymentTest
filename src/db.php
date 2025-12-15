<?php
// db.php
// This file contains the database connection details and establishes a PDO connection.
// Using PDO is crucial for preventing SQL injection attacks.

// Database credentials
// These values are now read from environment variables, typically set by docker-compose.
$host = getenv('MYSQL_HOST') ?: '127.0.0.1';
$dbname = getenv('MYSQL_DATABASE') ?: 'auth_system';
$user = getenv('MYSQL_USER') ?: 'root';
$pass = getenv('MYSQL_PASSWORD') ?: '';
$charset = 'utf8mb4';

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// Options for PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Trigger exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulated prepared statements
];

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // If connection fails, throw an exception
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
