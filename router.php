<?php
/**
 * Router script for PHP built-in server (Railway.app deployment)
 * This ensures all requests are handled correctly.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve the document root
$requested = __DIR__ . $uri;

// If a real file/directory exists, serve it directly
if ($uri !== '/' && file_exists($requested)) {
    return false; // serve the file as-is
}

// If root is requested, serve index.php (main landing page)
if ($uri === '/' || $uri === '') {
    require __DIR__ . '/index.php';
    return true;
}

// For all other PHP files, let PHP handle them
if (substr($uri, -4) === '.php') {
    $phpFile = __DIR__ . $uri;
    if (file_exists($phpFile)) {
        require $phpFile;
        return true;
    }
}

// 404 fallback
http_response_code(404);
echo "<h1>404 Not Found</h1>";
return true;
