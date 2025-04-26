<?php
// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>APP_KEY Check</h1>";

// Check environment variables
$appKey = getenv('APP_KEY');
echo "<p>APP_KEY environment variable: " . ($appKey ? 'Set to: ' . substr($appKey, 0, 10) . '...' : 'NOT SET') . "</p>";

// Check if .env file exists
$envPath = __DIR__ . '/../.env';
echo "<p>.env file exists: " . (file_exists($envPath) ? 'Yes' : 'No') . "</p>";

// If .env exists, check if APP_KEY is in it
if (file_exists($envPath)) {
    $envContents = file_get_contents($envPath);
    echo "<p>APP_KEY in .env file: " . (strpos($envContents, 'APP_KEY=') !== false ? 'Yes' : 'No') . "</p>";
}

// Generate a key for the user
echo "<h2>Generate New Key</h2>";
$bytes = random_bytes(16);
$key = 'base64:' . base64_encode($bytes);
echo "<p>Generated APP_KEY: " . $key . "</p>";
echo "<p>Add this key to your Render environment variables if needed.</p>";

// Show current environment
echo "<h2>Environment Information</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Current Directory: " . getcwd() . "</p>";

// Test file writing
echo "<h2>Environment File Creation Test</h2>";
try {
    $testFile = __DIR__ . '/../.env.test';
    file_put_contents($testFile, "APP_KEY=$key\n");
    echo "<p>Test file written successfully to: $testFile</p>";
} catch (Exception $e) {
    echo "<p>Error writing test file: " . $e->getMessage() . "</p>";
}

// Show current environment variables
echo "<h2>Current Environment Variables</h2>";
echo "<pre>";
$envVars = $_ENV;
foreach ($envVars as $key => $value) {
    if (in_array(strtolower($key), ['app_key', 'db_password', 'mail_password'])) {
        echo "$key: [REDACTED]\n";
    } else {
        echo "$key: $value\n";
    }
}
echo "</pre>";
?> 