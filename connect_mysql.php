<?php
// Load credentials from .env file
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue; // skip comments
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

$host    = $_ENV['DB_HOST']    ?? 'localhost';
$db      = $_ENV['DB_NAME']    ?? '';
$user    = $_ENV['DB_USER']    ?? '';
$pass    = $_ENV['DB_PASS']    ?? '';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch rows as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // use real prepared statements
];

// error_log("Connecting to mysql database...");

try {
    $conn = new PDO($dsn, $user, $pass, $options);
    // ✅ connection successful
} catch (PDOException $e) {
    // ❌ connection failed
    die('Database connection failed: ' . $e->getMessage());
}
?>