<?php

// Standalone diagnostic script for Laravel

echo "=========================================\n";
echo "Laravel Diagnostic Tool\n";
echo "=========================================\n\n";

// Check PHP version
echo "PHP Version: " . phpversion() . "\n";

// Check for key extensions
$requiredExtensions = ['mongodb', 'pdo_mysql', 'mbstring', 'json', 'openssl', 'tokenizer'];
echo "\nChecking PHP Extensions:\n";
foreach ($requiredExtensions as $ext) {
    echo " - $ext: " . (extension_loaded($ext) ? "Loaded ✓" : "Not Loaded ✗") . "\n";
}

// Check write permissions
echo "\nChecking directory permissions:\n";
$directories = [
    'storage',
    'storage/framework',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/framework/cache',
    'storage/logs',
    'bootstrap/cache'
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        echo " - $dir: Directory does not exist ✗\n";
        // Try to create it
        echo "   Attempting to create... ";
        if (@mkdir($dir, 0755, true)) {
            echo "Created ✓\n";
        } else {
            echo "Failed ✗\n";
        }
    } else {
        echo " - $dir: Exists";
        if (is_writable($dir)) {
            echo ", Writable ✓\n";
        } else {
            echo ", Not Writable ✗\n";
            echo "   Attempting to fix permissions... ";
            if (@chmod($dir, 0755)) {
                echo "Fixed ✓\n";
            } else {
                echo "Failed ✗\n";
            }
        }
    }
}

// Check environment configuration
echo "\nChecking environment configuration:\n";

if (file_exists('.env')) {
    echo " - .env file exists ✓\n";
    // Parse .env file
    $env = parse_env_file('.env');
    
    echo "   SESSION_DRIVER: " . ($env['SESSION_DRIVER'] ?? 'Not set') . "\n";
    echo "   CACHE_STORE: " . ($env['CACHE_STORE'] ?? 'Not set') . "\n";
    
    // Check for potential issues
    if (isset($env['SESSION_DRIVER']) && $env['SESSION_DRIVER'] === 'database') {
        echo "   Warning: SESSION_DRIVER is set to 'database' which requires MySQL connection ✗\n";
        echo "   Recommendation: Change SESSION_DRIVER to 'file' in .env file\n";
    }
    
    if (isset($env['CACHE_STORE']) && $env['CACHE_STORE'] === 'database') {
        echo "   Warning: CACHE_STORE is set to 'database' which requires MySQL connection ✗\n";
        echo "   Recommendation: Change CACHE_STORE to 'file' in .env file\n";
    }
} else {
    echo " - .env file does not exist ✗\n";
    echo "   Critical: Create .env file with proper configuration\n";
}

// Check config files
echo "\nChecking configuration files:\n";

if (file_exists('config/session.php')) {
    echo " - config/session.php exists ✓\n";
    $sessionConfig = file_get_contents('config/session.php');
    if (preg_match("/'driver' => env\('SESSION_DRIVER', '(.*?)'\),/", $sessionConfig, $matches)) {
        echo "   Default session driver: " . $matches[1] . "\n";
        if ($matches[1] !== 'file') {
            echo "   Warning: Default session driver is not 'file' ✗\n";
            echo "   Recommendation: Change default to 'file' in config/session.php\n";
        }
    }
} else {
    echo " - config/session.php does not exist ✗\n";
}

if (file_exists('config/cache.php')) {
    echo " - config/cache.php exists ✓\n";
    $cacheConfig = file_get_contents('config/cache.php');
    if (preg_match("/'default' => env\('CACHE_STORE', '(.*?)'\),/", $cacheConfig, $matches)) {
        echo "   Default cache store: " . $matches[1] . "\n";
        if ($matches[1] !== 'file') {
            echo "   Warning: Default cache store is not 'file' ✗\n";
            echo "   Recommendation: Change default to 'file' in config/cache.php\n";
        }
    }
} else {
    echo " - config/cache.php does not exist ✗\n";
}

echo "\n=========================================\n";
echo "Recommendations for fixing 500 Server Error:\n";
echo "=========================================\n";
echo "1. Update config/session.php to use 'file' as default driver\n";
echo "2. Update config/cache.php to use 'file' as default store\n";
echo "3. Update .env to use:\n";
echo "   SESSION_DRIVER=file\n";
echo "   CACHE_STORE=file\n";
echo "4. Ensure storage and bootstrap/cache directories are writable\n";
echo "5. Clear Laravel caches with:\n";
echo "   php artisan config:clear\n";
echo "   php artisan route:clear\n";
echo "   php artisan view:clear\n";
echo "   php artisan optimize:clear\n";
echo "=========================================\n";

// Helper function to parse .env file
function parse_env_file($path) {
    $content = file_get_contents($path);
    $env = [];
    
    foreach (explode("\n", $content) as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }
        
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes if present
            $value = trim($value, "'\"");
            
            $env[$key] = $value;
        }
    }
    
    return $env;
} 