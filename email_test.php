<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "Starting email test...\n";

// Get mail configuration from environment
$mailHost = env('MAIL_HOST');
$mailPort = env('MAIL_PORT');
$mailUsername = env('MAIL_USERNAME');
$mailPassword = env('MAIL_PASSWORD');
$mailFromAddress = env('MAIL_FROM_ADDRESS');
$mailFromName = env('MAIL_FROM_NAME');

echo "Mail configuration loaded.\n";
echo "Host: $mailHost\n";
echo "Port: $mailPort\n";
echo "Username: $mailUsername\n";
echo "From Address: $mailFromAddress\n";
echo "From Name: $mailFromName\n";

echo "Attempting to send email...\n";

try {
    Mail::raw('This is a test email to verify SMTP configuration', function($message) use ($mailUsername) {
        $message->to($mailUsername)->subject('Test Email from Laravel');
    });
    echo "Email sent successfully!\n";
} catch (Exception $e) {
    echo "Error sending email: " . $e->getMessage() . "\n";
} 