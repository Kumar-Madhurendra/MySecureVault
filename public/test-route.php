<?php
// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
try {
    $dotenv->load();
} catch (Exception $e) {
    echo "Warning: Error loading .env file: " . $e->getMessage();
}

// Create Laravel app
$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

// Register service providers
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

// Bootstrap the application
$app->bootstrap();

// Return a successful response
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Test route is working!',
    'environment' => $_ENV['APP_ENV'] ?? 'unknown',
    'debug' => $_ENV['APP_DEBUG'] ?? false,
    'database' => $_ENV['DB_CONNECTION'] ?? 'unknown'
]);
?> 