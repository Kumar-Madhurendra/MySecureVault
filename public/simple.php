<?php

// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Information about the environment
echo "<h1>Environment Information</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Environment: " . (getenv('APP_ENV') ?: 'not set') . "</p>";
echo "<p>Debug Mode: " . (getenv('APP_DEBUG') ?: 'not set') . "</p>";

// Path information
echo "<h2>Path Information</h2>";
echo "<p>Current File: " . __FILE__ . "</p>";
echo "<p>Current Directory: " . __DIR__ . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";

// Try to load Laravel
echo "<h2>Loading Laravel</h2>";
try {
    $autoloadFile = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($autoloadFile)) {
        echo "<p>✓ Autoload file found at $autoloadFile</p>";
        require $autoloadFile;
    } else {
        echo "<p>✗ Autoload file not found at $autoloadFile</p>";
        die("Cannot proceed without autoloader");
    }

    // Check if key Laravel classes exist
    echo "<h2>Laravel Class Check</h2>";
    $laravelClasses = [
        'Illuminate\Foundation\Application',
        'Illuminate\Http\Request',
        'Illuminate\Support\Facades\Route',
        'MongoDB\Client',
        'Jenssegers\Mongodb\MongodbServiceProvider',
    ];

    foreach ($laravelClasses as $class) {
        echo "<p>" . (class_exists($class) ? "✓" : "✗") . " $class</p>";
    }

    // Try to initialize Laravel
    echo "<h2>Laravel Initialization</h2>";
    try {
        echo "<p>Attempting to bootstrap Laravel...</p>";
        
        // Create .env file if missing
        $envFile = __DIR__ . '/../.env';
        if (!file_exists($envFile)) {
            echo "<p>Creating .env file...</p>";
            $envContent = "APP_NAME=MySecureVault\n";
            $envContent .= "APP_ENV=production\n";
            $envContent .= "APP_KEY=base64:qxSzYJ7RRJRf7+OWcblSCmYVxlXQcpMFLLnFmGM92sw=\n";
            $envContent .= "APP_DEBUG=true\n";
            $envContent .= "DB_CONNECTION=mongodb\n";
            $envContent .= "DB_HOST=" . (getenv('DB_HOST') ?: 'localhost') . "\n";
            $envContent .= "DB_PORT=" . (getenv('DB_PORT') ?: '27017') . "\n";
            $envContent .= "DB_DATABASE=" . (getenv('DB_DATABASE') ?: 'my_project') . "\n";
            $envContent .= "DB_USERNAME=" . (getenv('DB_USERNAME') ?: 'user') . "\n";
            $envContent .= "DB_PASSWORD=" . (getenv('DB_PASSWORD') ?: 'password') . "\n";
            $envContent .= "MONGODB_URI=" . (getenv('MONGODB_URI') ?: 'mongodb://localhost:27017/my_project') . "\n";
            
            if (file_put_contents($envFile, $envContent)) {
                echo "<p>✓ .env file created successfully</p>";
            } else {
                echo "<p>✗ Failed to create .env file</p>";
            }
        } else {
            echo "<p>✓ .env file already exists</p>";
        }
        
        // Load application
        /** @var \Illuminate\Foundation\Application $app */
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        echo "<p>✓ Laravel application loaded</p>";
        
        // Start app 
        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
        echo "<p>✓ HTTP Kernel created</p>";
        
        // Create a test response
        echo "<h2>Simple Test Response</h2>";
        return response()->json([
            'status' => 'success',
            'message' => 'Laravel is working!',
            'database' => config('database.default'),
            'mongodb_uri' => config('database.connections.mongodb.dsn')
        ]);
        
    } catch (Exception $e) {
        echo "<p>✗ Laravel initialization error: " . $e->getMessage() . "</p>";
        echo "<p>Error occurred in: " . $e->getFile() . " on line " . $e->getLine() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
} catch (Exception $e) {
    echo "<p>✗ General error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?> 