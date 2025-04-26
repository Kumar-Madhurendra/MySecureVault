<?php
// Set error reporting to maximum
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Register an error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    echo "<div style='background: #FFF0F0; border-left: 4px solid #FF0000; padding: 10px; margin: 10px 0;'>";
    echo "<h3>Error Occurred</h3>";
    echo "<p><strong>Message:</strong> $errstr</p>";
    echo "<p><strong>File:</strong> $errfile on line $errline</p>";
    echo "</div>";
});

// Register an exception handler
set_exception_handler(function($e) {
    echo "<div style='background: #FFF0F0; border-left: 4px solid #FF0000; padding: 10px; margin: 10px 0;'>";
    echo "<h3>Exception Occurred</h3>";
    echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
    echo "<p><strong>Stack Trace:</strong></p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
});

try {
    // Try to load the Laravel application
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    // Handle the request
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    
    // Send the response
    $response->send();
    
    // Terminate the request
    $kernel->terminate($request, $response);
} catch (Exception $e) {
    // Already handled by the exception handler
}
?> 