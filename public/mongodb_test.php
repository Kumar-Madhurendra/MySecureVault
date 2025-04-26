<?php
// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>MongoDB Direct Connection Test</h1>";

// Test MongoDB extension
echo "<h2>Extension Check</h2>";
if (extension_loaded('mongodb')) {
    echo "<p>✓ MongoDB extension is loaded</p>";
} else {
    echo "<p>✗ MongoDB extension is NOT loaded</p>";
    die("Cannot proceed without MongoDB extension");
}

// Check if MongoDB PHP library is available
echo "<h2>PHP Library Check</h2>";
if (class_exists('MongoDB\Client')) {
    echo "<p>✓ MongoDB\Client class exists</p>";
} else {
    echo "<p>✗ MongoDB\Client class does NOT exist</p>";
    echo "<p>Trying to load vendor autoload...</p>";
    
    // Try to load Composer autoloader
    $autoloadFile = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($autoloadFile)) {
        require_once $autoloadFile;
        if (class_exists('MongoDB\Client')) {
            echo "<p>✓ MongoDB\Client class found after loading autoloader</p>";
        } else {
            echo "<p>✗ MongoDB\Client class STILL NOT found after loading autoloader</p>";
            die("Cannot proceed without MongoDB library");
        }
    } else {
        echo "<p>✗ Composer autoloader not found at $autoloadFile</p>";
        die("Cannot proceed without autoloader");
    }
}

// Get MongoDB connection string
echo "<h2>Connection Details</h2>";
$mongoUri = getenv('MONGODB_URI');
if (!$mongoUri) {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $database = getenv('DB_DATABASE');
    $username = getenv('DB_USERNAME');
    $password = getenv('DB_PASSWORD');
    
    if ($host && $port && $database && $username && $password) {
        $mongoUri = "mongodb+srv://$username:$password@$host/$database?retryWrites=true&w=majority";
    }
}

if (!$mongoUri) {
    echo "<p>✗ No MongoDB connection string available</p>";
    die("Cannot proceed without connection details");
} else {
    echo "<p>✓ MongoDB connection string is available</p>";
}

// Test connection
echo "<h2>Connection Test</h2>";
try {
    echo "<p>Attempting to connect to MongoDB...</p>";
    $client = new MongoDB\Client($mongoUri);
    echo "<p>✓ Connection established successfully!</p>";
    
    // List databases
    echo "<h2>Database List</h2>";
    $databaseNames = [];
    foreach ($client->listDatabases() as $dbInfo) {
        $databaseNames[] = $dbInfo->getName();
    }
    
    if (count($databaseNames) > 0) {
        echo "<p>✓ Found " . count($databaseNames) . " databases:</p>";
        echo "<ul>";
        foreach ($databaseNames as $dbName) {
            echo "<li>$dbName</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>✗ No databases found</p>";
    }
    
    // Try to access the specific database
    $dbName = getenv('DB_DATABASE') ?: 'my_project';
    echo "<h2>Database Access Test: $dbName</h2>";
    $database = $client->selectDatabase($dbName);
    
    // List collections
    $collections = [];
    foreach ($database->listCollections() as $collection) {
        $collections[] = $collection->getName();
    }
    
    if (count($collections) > 0) {
        echo "<p>✓ Found " . count($collections) . " collections in $dbName:</p>";
        echo "<ul>";
        foreach ($collections as $collectionName) {
            echo "<li>$collectionName</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No collections found in $dbName database</p>";
    }
    
    // Try to query a collection
    if (in_array('users', $collections)) {
        echo "<h2>Sample Query</h2>";
        $userCount = $database->users->countDocuments([]);
        echo "<p>Number of users: $userCount</p>";
        
        $users = $database->users->find([], ['limit' => 3]);
        echo "<p>First 3 users (sanitized):</p>";
        echo "<ul>";
        foreach ($users as $user) {
            echo "<li>ID: " . $user['_id'] . " | Email: " . (isset($user['email']) ? substr($user['email'], 0, 3) . '***' : 'N/A') . "</li>";
        }
        echo "</ul>";
    }
    
} catch (Exception $e) {
    echo "<p>✗ Connection error: " . $e->getMessage() . "</p>";
    echo "<p>Error trace:</p><pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Environment Variables</h2>";
echo "<pre>";
$vars = $_ENV;
foreach ($vars as $key => $value) {
    if (strpos(strtolower($key), 'password') !== false || strpos(strtolower($key), 'key') !== false) {
        echo "$key: [REDACTED]\n";
    } else {
        echo "$key: $value\n";
    }
}
echo "</pre>";

echo "<p>Test completed.</p>";
?> 