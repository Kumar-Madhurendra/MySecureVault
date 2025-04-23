<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email? : The email address to send the test to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify SMTP configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emailTo = $this->argument('email') ?: config('mail.from.address');
        
        $this->info('Starting email test...');
        $this->info('Mail configuration:');
        $this->info('Host: ' . config('mail.mailers.smtp.host'));
        $this->info('Port: ' . config('mail.mailers.smtp.port'));
        $this->info('Username: ' . config('mail.mailers.smtp.username'));
        $this->info('From Address: ' . config('mail.from.address'));
        $this->info('From Name: ' . config('mail.from.name'));
        
        $this->info('Attempting to send email to: ' . $emailTo);
        
        try {
            Mail::raw('This is a test email to verify SMTP configuration sent at ' . now(), function($message) use ($emailTo) {
                $message->to($emailTo)->subject('Test Email from Laravel');
            });
            
            $this->info('Email sent successfully!');
        } catch (\Exception $e) {
            $this->error('Error sending email: ' . $e->getMessage());
        }
    }
}
