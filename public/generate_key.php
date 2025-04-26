<?php
// Generate a random 32-character string for APP_KEY
function generateRandomKey() {
    $bytes = random_bytes(16);
    return 'base64:' . base64_encode($bytes);
}

$key = generateRandomKey();
echo "Your generated APP_KEY is: " . $key;
echo "<p>Add this to your Render environment variables.</p>";
?> 