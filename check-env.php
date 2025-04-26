<?php
echo "Environment check script\n";
echo "=====================\n\n";

echo "Current working directory: " . getcwd() . "\n";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "\n\n";

echo "Directory structure:\n";
$dirs = ['public', 'storage', 'bootstrap/cache'];
foreach ($dirs as $dir) {
    echo "$dir: " . (is_dir($dir) ? "exists" : "MISSING") . "\n";
}

echo "\nPublic directory contents:\n";
if (is_dir('public')) {
    $files = scandir('public');
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "- $file" . (is_dir("public/$file") ? "/" : "") . "\n";
        }
    }
} else {
    echo "Public directory doesn't exist\n";
}

echo "\nPHP info:\n";
echo "PHP version: " . phpversion() . "\n";
$extensions = get_loaded_extensions();
echo "MongoDB extension: " . (in_array('mongodb', $extensions) ? "loaded" : "NOT LOADED") . "\n";

echo "\nEnvironment variables:\n";
echo "APP_ENV: " . (getenv('APP_ENV') ?: 'not set') . "\n";
echo "APP_DEBUG: " . (getenv('APP_DEBUG') ?: 'not set') . "\n";
echo "DB_CONNECTION: " . (getenv('DB_CONNECTION') ?: 'not set') . "\n";
?> 