<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Check if user already exists
            $user = User::where('provider_id', $socialUser->getId())
                       ->where('provider', $provider)
                       ->first();
            
            // If user doesn't exist, create a new user
            if (!$user) {
                // Check if email already exists
                $existingUser = User::where('email', $socialUser->getEmail())->first();
                
                if ($existingUser) {
                    // Update existing user with provider information
                    $existingUser->provider = $provider;
                    $existingUser->provider_id = $socialUser->getId();
                    $existingUser->avatar = $socialUser->getAvatar();
                    $existingUser->save();
                    
                    $user = $existingUser;
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $socialUser->getName(),
                        'email' => $socialUser->getEmail(),
                        'password' => Hash::make(rand(1,10000)),
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                        'avatar' => $socialUser->getAvatar()
                    ]);
                }
            }
            
            // Login the user
            Auth::login($user);
            
            return redirect('/home');
            
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong with social authentication. Please try again.');
        }
    }
} 