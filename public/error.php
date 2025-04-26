<?php
// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Basic information
echo "PHP Version: " . phpversion() . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Current Directory: " . getcwd() . "<br>";

// Check storage directory
$storageDir = __DIR__ . '/../storage';
echo "Storage directory exists: " . (is_dir($storageDir) ? 'Yes' : 'No') . "<br>";
echo "Storage directory writable: " . (is_writable($storageDir) ? 'Yes' : 'No') . "<br>";

// Check bootstrap/cache directory
$cacheDir = __DIR__ . '/../bootstrap/cache';
echo "Cache directory exists: " . (is_dir($cacheDir) ? 'Yes' : 'No') . "<br>";
echo "Cache directory writable: " . (is_writable($cacheDir) ? 'Yes' : 'No') . "<br>";

// Check .env file
$envFile = __DIR__ . '/../.env';
echo ".env file exists: " . (file_exists($envFile) ? 'Yes' : 'No') . "<br>";

// Get environment variables
echo "<h3>Environment Variables:</h3>";
echo "<pre>";
$envVars = $_ENV;
$sensitiveKeys = ['APP_KEY', 'DB_PASSWORD', 'MAIL_PASSWORD'];
foreach ($envVars as $key => $value) {
    if (in_array($key, $sensitiveKeys)) {
        $value = '***REDACTED***';
    }
    echo "$key: $value\n";
}
echo "</pre>";
?> 