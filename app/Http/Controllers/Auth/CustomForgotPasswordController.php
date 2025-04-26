<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomForgotPasswordController extends Controller
{
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->email;

        try {
            // Log attempt for debugging
            Log::info('Password reset initiated for: ' . $email);
            
            // Check if user exists
            $user = DB::table('users')->where('email', $email)->first();
            
            if (!$user) {
                Log::info('User not found for password reset: ' . $email);
                return back()->withErrors(['email' => 'We could not find a user with that email address.']);
            }

            // Generate a new reset token
            $token = Str::random(64);
            
            // Store the token in the password_resets table
            DB::table('password_resets')->where('email', $email)->delete();
            
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => now()
            ]);
            
            // Use Laravel's standard password broker
            $status = Password::sendResetLink(
                $request->only('email')
            );
            
            Log::info('Password reset response', [
                'email' => $email,
                'status' => $status
            ]);

            return $status === Password::RESET_LINK_SENT
                ? back()->with('status', 'We have sent you a password reset link. Please check both your inbox and spam folder.')
                : back()->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            Log::error('Password reset error', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['email' => 'There was an error sending the password reset link. Please try again later.']);
        }
    }
}