<?php
// Set to display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Debug Information</h1>";

// Environment
echo "<h2>Environment</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Extensions loaded: " . implode(", ", get_loaded_extensions()) . "</p>";
echo "<p>Environment variables:</p><ul>";
foreach ($_ENV as $key => $value) {
    // Don't display sensitive values
    if (in_array(strtolower($key), ['app_key', 'db_password', 'mail_password'])) {
        echo "<li>$key: [REDACTED]</li>";
    } else {
        echo "<li>$key: $value</li>";
    }
}
echo "</ul>";

// Storage permissions
echo "<h2>Storage Permissions</h2>";
$storagePath = __DIR__ . '/../storage';
echo "<p>Storage path: $storagePath</p>";
echo "<p>Exists: " . (file_exists($storagePath) ? 'Yes' : 'No') . "</p>";
echo "<p>Readable: " . (is_readable($storagePath) ? 'Yes' : 'No') . "</p>";
echo "<p>Writable: " . (is_writable($storagePath) ? 'Yes' : 'No') . "</p>";

// Key Laravel directories
$directories = [
    'storage/app',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache'
];

echo "<h2>Laravel Directory Permissions</h2>";
echo "<ul>";
foreach ($directories as $dir) {
    $path = __DIR__ . '/../' . $dir;
    echo "<li>$dir - Exists: " . (file_exists($path) ? 'Yes' : 'No');
    if (file_exists($path)) {
        echo " | Readable: " . (is_readable($path) ? 'Yes' : 'No');
        echo " | Writable: " . (is_writable($path) ? 'Yes' : 'No');
    }
    echo "</li>";
}
echo "</ul>";

// Check .env file
echo "<h2>Environment File</h2>";
$envPath = __DIR__ . '/../.env';
echo "<p>.env path: $envPath</p>";
echo "<p>Exists: " . (file_exists($envPath) ? 'Yes' : 'No') . "</p>";
if (file_exists($envPath)) {
    echo "<p>Readable: " . (is_readable($envPath) ? 'Yes' : 'No') . "</p>";
    // Don't show contents for security, but check if it has content
    echo "<p>Size: " . filesize($envPath) . " bytes</p>";
}

// Test database connection
echo "<h2>Database Connection Test</h2>";
if (extension_loaded('mongodb')) {
    echo "<p>MongoDB extension is loaded</p>";
    
    // Check if mongodb library is installed
    if (class_exists('MongoDB\Client')) {
        echo "<p>MongoDB PHP library is installed</p>";
        
        // Try to get MongoDB connection details from environment
        $mongoUri = getenv('MONGODB_URI') ?: (getenv('DB_CONNECTION') == 'mongodb' ? 
            'mongodb://' . getenv('DB_USERNAME') . ':' . getenv('DB_PASSWORD') . '@' . 
            getenv('DB_HOST') . ':' . getenv('DB_PORT') . '/' . getenv('DB_DATABASE') : null);
        
        if ($mongoUri) {
            echo "<p>Attempting to connect with URI: [REDACTED]</p>";
            try {
                $client = new MongoDB\Client($mongoUri);
                echo "<p>Connection established successfully!</p>";
                // List databases to verify connection
                $databaseList = [];
                foreach ($client->listDatabases() as $db) {
                    $databaseList[] = $db->getName();
                }
                echo "<p>Available databases: " . implode(", ", $databaseList) . "</p>";
            } catch (Exception $e) {
                echo "<p>Connection error: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>MongoDB connection URI not available in environment variables</p>";
        }
    } else {
        echo "<p>MongoDB extension is loaded but the PHP library is NOT installed. Run 'composer require mongodb/mongodb'</p>";
        echo "<p>Installed Composer packages:</p>";
        if (file_exists(__DIR__ . '/../vendor/composer/installed.json')) {
            $packages = json_decode(file_get_contents(__DIR__ . '/../vendor/composer/installed.json'), true);
            echo "<pre>" . print_r($packages, true) . "</pre>";
        } else {
            echo "<p>No composer packages found</p>";
        }
    }
} else {
    echo "<p>MongoDB extension is NOT loaded</p>";
}

// Show logs
echo "<h2>Recent Log Entries</h2>";
$logPath = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logPath) && is_readable($logPath)) {
    echo "<p>Log file exists and is readable</p>";
    // Get the last 50 lines
    $lines = array_slice(file($logPath), -50);
    echo "<pre>" . htmlspecialchars(implode("", $lines)) . "</pre>";
} else {
    echo "<p>Log file doesn't exist or is not readable at: $logPath</p>";
}

echo "<p>Debug information complete.</p>";
?> 