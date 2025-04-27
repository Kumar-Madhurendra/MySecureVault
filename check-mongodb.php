<?php

// Simple script to check MongoDB connection

// Check if MongoDB extension is loaded
echo "MongoDB Extension Loaded: " . (extension_loaded('mongodb') ? 'YES' : 'NO') . "\n";

// Check PHP version
echo "PHP Version: " . phpversion() . "\n";

// Check MongoDB extension version if loaded
if (extension_loaded('mongodb')) {
    echo "MongoDB Extension Version: " . phpversion('mongodb') . "\n";
}

// Try to connect to MongoDB using the driver directly
try {
    // Load .env file if exists
    if (file_exists(__DIR__ . '/.env')) {
        $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            if (!empty($name)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
    
    // Get MongoDB URI from environment
    $mongoUri = getenv('MONGO_DB_URI') ?: 'mongodb://localhost:27017';
    $mongoDatabase = getenv('MONGO_DB_DATABASE') ?: 'my_project';
    
    echo "Attempting to connect to: " . $mongoUri . "\n";
    
    // Create MongoDB client
    $client = new MongoDB\Driver\Manager($mongoUri);
    
    // Execute a simple command to verify connection
    $command = new MongoDB\Driver\Command(['ping' => 1]);
    $result = $client->executeCommand($mongoDatabase, $command);
    $response = current($result->toArray());
    
    echo "Connection Status: " . ($response->ok ? 'SUCCESS' : 'FAILED') . "\n";
    
    // List all databases
    $listDatabases = new MongoDB\Driver\Command(['listDatabases' => 1]);
    $databases = $client->executeCommand('admin', $listDatabases);
    $databasesList = current($databases->toArray());
    
    echo "Available Databases:\n";
    foreach ($databasesList->databases as $database) {
        echo " - " . $database->name . "\n";
    }
    
} catch (Exception $e) {
    echo "Connection Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "Script completed.\n"; 