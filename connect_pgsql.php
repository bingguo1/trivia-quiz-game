<?php
// Credentials loaded by connect.php from .env
$host   = $_ENV['PGSQL_HOST']   ?? '';
$port   = $_ENV['PGSQL_PORT']   ?? '5432';
$db     = $_ENV['PGSQL_NAME']   ?? 'postgres';
$user   = $_ENV['PGSQL_USER']   ?? '';
$pass   = $_ENV['PGSQL_PASS']   ?? '';
$schema = $_ENV['PGSQL_SCHEMA'] ?? 'public';

$dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// error_log("Connecting to Supabase PostgreSQL...");

try {
    $conn = new PDO($dsn, $user, $pass, $options);
    // Set the schema search path so table names resolve to the correct schema
    $conn->exec("SET search_path TO $schema");
    // ✅ connection successful
} catch (PDOException $e) {
    // ❌ connection failed
    die('Database connection failed: ' . $e->getMessage());
}
?>
