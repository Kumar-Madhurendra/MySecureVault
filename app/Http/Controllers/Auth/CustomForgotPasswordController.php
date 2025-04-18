<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CustomForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            // First, let's log the attempt
            Log::info('Password reset initiated for: ' . $request->email);

            // Try to send a test email first
            Mail::raw('Password reset test email', function ($message) use ($request) {
                $message->to($request->email)
                       ->subject('Password Reset Test');
            });

            // If test email succeeds, proceed with actual reset
            $response = Password::broker()->sendResetLink(
                $request->only('email')
            );

            Log::info('Password reset response', [
                'email' => $request->email,
                'response' => $response
            ]);

            if ($response == Password::RESET_LINK_SENT) {
                return back()->with('status', 'Password reset link has been sent to your email. Please check both inbox and spam folder.');
            }

            return back()->withErrors(['email' => trans($response)]);

        } catch (\Exception $e) {
            Log::error('Password reset error', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['email' => 'Error sending password reset email: ' . $e->getMessage()]);
        }
    }
}