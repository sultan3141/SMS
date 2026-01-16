<?php

// Router script for PHP built-in server
// This helps handle concurrent requests better

// Get the URI path without query string
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$filePath = __DIR__ . '/public' . $uri;

// Debug logging
error_log("URI: $uri");
error_log("File path: $filePath");
error_log("File exists: " . (file_exists($filePath) ? 'YES' : 'NO'));

// Serve static files directly (check if file exists in public directory)
if ($uri !== '/' && file_exists($filePath)) {
    // Let PHP's built-in server serve the file
    error_log("Serving static file: $filePath");
    return false;
}

// Forward all other requests to Laravel's public/index.php
error_log("Forwarding to Laravel: $uri");
require_once __DIR__ . '/public/index.php';
