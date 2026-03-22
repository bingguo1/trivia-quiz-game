<?php
// GAE PHP runtime requires index.php as the front controller.
// Route requests: serve PHP files directly, serve HTML files, fall back to index.html.

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . $uri;

// Serve .php files by including them
if (preg_match('/\.php$/', $uri)) {
    if (file_exists($file)) {
        require $file;
        exit;
    }
    // Also check api/ subdirectory for bare /foo.php -> /api/foo.php
    $apiFile = __DIR__ . '/api' . $uri;
    if (file_exists($apiFile)) {
        require $apiFile;
        exit;
    }
}

// Serve .html files directly with correct content type
if (preg_match('/\.html$/', $uri) && file_exists($file)) {
    header('Content-Type: text/html; charset=utf-8');
    readfile($file);
    exit;
}

// Default: serve index.html
header('Content-Type: text/html; charset=utf-8');
readfile(__DIR__ . '/index.html');
