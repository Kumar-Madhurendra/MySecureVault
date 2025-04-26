<?php
/**
 * Redirect to the public directory
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// If the file exists in the public directory, serve it directly
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

// Otherwise, redirect to the public/index.php
require_once __DIR__.'/public/index.php';
?> 