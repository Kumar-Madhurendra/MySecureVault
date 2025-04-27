<?php

// Script to fix session configuration and permissions
echo "Starting session configuration fix script...\n\n";

// 1. Check and create storage directories if they don't exist
$directories = [
    'storage/framework',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/framework/cache',
    'storage/logs',
];

echo "Checking storage directories...\n";
foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        echo "Creating directory: $dir\n";
        mkdir($dir, 0775, true);
    } else {
        echo "Directory exists: $dir\n";
    }
}

// 2. Update permissions
echo "\nSetting permissions...\n";
$permissionDirs = [
    'storage',
    'bootstrap/cache',
];

foreach ($permissionDirs as $dir) {
    if (file_exists($dir)) {
        echo "Setting permissions for $dir\n";
        chmod($dir, 0775);
        
        // Recursive chmod for subdirectories
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $item) {
            chmod($item, 0775);
        }
    }
}

// 3. Update configuration
echo "\nUpdating configuration...\n";

// Update session driver in Laravel config
$sessionConfigPath = 'config/session.php';
if (file_exists($sessionConfigPath)) {
    $sessionConfig = file_get_contents($sessionConfigPath);
    $updatedConfig = preg_replace(
        "/'driver' => env\('SESSION_DRIVER', '(.*?)'\),/",
        "'driver' => env('SESSION_DRIVER', 'file'),",
        $sessionConfig
    );
    
    if ($sessionConfig !== $updatedConfig) {
        file_put_contents($sessionConfigPath, $updatedConfig);
        echo "Updated session driver to 'file' in $sessionConfigPath\n";
    } else {
        echo "Session driver already set to 'file' in $sessionConfigPath\n";
    }
}

// Update cache driver in Laravel config
$cacheConfigPath = 'config/cache.php';
if (file_exists($cacheConfigPath)) {
    $cacheConfig = file_get_contents($cacheConfigPath);
    $updatedCache = preg_replace(
        "/'default' => env\('CACHE_STORE', '(.*?)'\),/",
        "'default' => env('CACHE_STORE', 'file'),",
        $cacheConfig
    );
    
    if ($cacheConfig !== $updatedCache) {
        file_put_contents($cacheConfigPath, $updatedCache);
        echo "Updated cache store to 'file' in $cacheConfigPath\n";
    } else {
        echo "Cache store already set to 'file' in $cacheConfigPath\n";
    }
}

// 4. Clear Laravel cache
echo "\nClearing Laravel cache...\n";
$commands = [
    'php artisan config:clear',
    'php artisan cache:clear',
    'php artisan route:clear',
    'php artisan view:clear',
];

foreach ($commands as $command) {
    echo "Running: $command\n";
    system($command, $result);
    echo "Result: " . ($result === 0 ? "Success" : "Failed") . "\n";
}

echo "\nSession configuration fix completed!\n";
echo "If your application is still having errors, please check your Laravel logs.\n"; 