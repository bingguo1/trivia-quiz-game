<?php

// Load .env file for local development (not present on Google App Engine)
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        [$key, $value] = explode('=', $line, 2);
        // Only set if not already in the environment (GAE sets them natively)
        if (!isset($_ENV[trim($key)])) {
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Also pull in any vars set natively by the environment (e.g. GAE env_variables)
foreach (['DB_CONNECTION','DB_HOST','DB_NAME','DB_USER','DB_PASS','DB_CHARSET',
          'PGSQL_HOST','PGSQL_PORT','PGSQL_NAME','PGSQL_USER','PGSQL_PASS','PGSQL_SCHEMA'] as $key) {
    if (!isset($_ENV[$key]) && getenv($key) !== false) {
        $_ENV[$key] = getenv($key);
    }
}

// Route to the correct database driver (set DB_CONNECTION in .env or app.yaml)
$dbConnection = $_ENV['DB_CONNECTION'] ?? 'mysql';

if ($dbConnection === 'pgsql') {
    include __DIR__ . '/connect_pgsql.php';   // Supabase cloud PostgreSQL
} else {
    include __DIR__ . '/connect_mysql.php';   // Local MySQL
}

?>
