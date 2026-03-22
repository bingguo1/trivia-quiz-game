<?php

// Load .env credentials
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

// Route to the correct database driver (set DB_CONNECTION in .env)
$dbConnection = $_ENV['DB_CONNECTION'] ?? 'mysql';

if ($dbConnection === 'pgsql') {
    include __DIR__ . '/connect_pgsql.php';   // Supabase cloud PostgreSQL
} else {
    include __DIR__ . '/connect_mysql.php';   // Local MySQL
}

?>
