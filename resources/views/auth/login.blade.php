@extends('layouts.app')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        overflow: hidden;
        transition: background-color 0.3s ease;
    }

    body.dark-mode {
        background-color: #111827;
        color: #f3f4f6;
    }

    body.light-mode {
        background-color: #f8fafc;
        color: #1f2937;
    }

    .login-container {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .card-custom {
        width: 100%;
        max-width: 380px;
        border: none;
        border-radius: 12px;
        padding: 18px 16px;
        transition: all 0.3s ease;
        max-height: 98vh;
        overflow-y: auto;
    }

    body.dark-mode .card-custom {
        background: rgba(31, 41, 55, 0.85);
        color: #f3f4f6;
        backdrop-filter: blur(10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(75, 85, 99, 0.3);
    }

    body.light-mode .card-custom {
        background: rgba(255, 255, 255, 0.95);
        color: #1f2937;
        backdrop-filter: blur(10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(229, 231, 235, 0.5);
    }

    .card-custom:hover {
        transform: translateY(-2px);
    }

    .card-header-custom {
        text-align: center;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    body.dark-mode .card-header-custom {
        color: #f3f4f6;
    }

    body.light-mode .card-header-custom {
        color: #1f2937;
    }

    .login-image {
        display: block;
        margin: 0 auto 8px auto;
        width: 45px;
        height: auto;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }

    body.dark-mode .login-image {
        filter: brightness(0.9) drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
    }

    .form-label {
        font-weight: 600;
        font-size: 0.75rem;
        margin-bottom: 2px;
        display: block;
    }

    body.dark-mode .form-label {
        color: #d1d5db;
    }

    body.light-mode .form-label {
        color: #4b5563;
    }

    .form-control {
        border-radius: 6px;
        padding: 6px 10px;
        height: auto;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    body.dark-mode .form-control {
        background-color: rgba(31, 41, 55, 0.8);
        border: 1px solid #4b5563;
        color: #f3f4f6;
    }

    body.light-mode .form-control {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        color: #1f2937;
    }

    body.dark-mode .form-control:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.25);
        background-color: rgba(31, 41, 55, 0.9);
    }

    body.light-mode .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
        background-color: #ffffff;
    }

    .btn-primary {
        border: none;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
        width: 100%;
        margin-top: 4px;
        font-size: 0.85rem;
    }

    body.dark-mode .btn-primary {
        background-color: #8b5cf6;
    }

    body.light-mode .btn-primary {
        background-color: #6366f1;
    }

    body.dark-mode .btn-primary:hover {
        background-color: #7c3aed;
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(139, 92, 246, 0.3);
    }

    body.light-mode .btn-primary:hover {
        background-color: #4f46e5;
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(99, 102, 241, 0.2);
    }

    .btn-social {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        padding: 6px 12px;
        transition: all 0.2s ease;
        font-weight: 600;
        width: 100%;
        margin-bottom: 6px;
        text-align: center;
        font-size: 0.8rem;
    }

    body.dark-mode .btn-social {
        border: 1px solid #4b5563;
    }

    body.light-mode .btn-social {
        border: 1px solid #e5e7eb;
    }

    .btn-social:hover {
        transform: translateY(-1px);
    }

    body.dark-mode .btn-social:hover {
        box-shadow: 0 3px 10px rgba(255, 255, 255, 0.1);
    }

    body.light-mode .btn-social:hover {
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    }

    body.dark-mode .btn-google {
        background-color: #374151;
        color: #f3f4f6;
    }

    body.light-mode .btn-google {
        background-color: #ffffff;
        color: #1f2937;
    }

    body.dark-mode .btn-google:hover {
        background-color: #4b5563;
    }

    body.light-mode .btn-google:hover {
        background-color: #f9fafb;
    }

    body.dark-mode .btn-github {
        background-color: #1f2937;
        color: #f3f4f6;
    }

    body.light-mode .btn-github {
        background-color: #24292e;
        color: #ffffff;
    }

    body.dark-mode .btn-github:hover {
        background-color: #374151;
    }

    body.light-mode .btn-github:hover {
        background-color: #333c44;
    }

    .btn-link {
        font-weight: 500;
        font-size: 0.75rem;
        text-decoration: none;
        transition: color 0.2s ease;
        padding: 0;
    }

    body.dark-mode .btn-link {
        color: #d1d5db;
    }

    body.light-mode .btn-link {
        color: #6b7280;
    }

    body.dark-mode .btn-link:hover {
        color: #a78bfa;
    }

    body.light-mode .btn-link:hover {
        color: #4f46e5;
        text-decoration: none;
    }

    .form-check-input {
        border-radius: 3px;
        width: 0.8rem;
        height: 0.8rem;
        margin-top: 0.25rem;
    }

    body.dark-mode .form-check-input {
        border: 1px solid #4b5563;
        background-color: rgba(31, 41, 55, 0.8);
    }

    body.light-mode .form-check-input {
        border: 1px solid #d1d5db;
        background-color: #ffffff;
    }

    body.dark-mode .form-check-input:checked {
        background-color: #8b5cf6;
        border-color: #8b5cf6;
    }

    body.light-mode .form-check-input:checked {
        background-color: #6366f1;
        border-color: #6366f1;
    }

    .form-check-label {
        font-size: 0.75rem;
        padding-top: 1px;
    }

    body.dark-mode .form-check-label {
        color: #d1d5db;
    }

    body.light-mode .form-check-label {
        color: #6b7280;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.7rem;
        margin-top: 2px;
    }

    body.dark-mode .invalid-feedback {
        color: #fca5a5;
    }

    .or-divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 8px 0;
        font-size: 0.75rem;
    }

    body.dark-mode .or-divider {
        color: #9ca3af;
    }

    body.light-mode .or-divider {
        color: #9ca3af;
    }

    .or-divider::before, .or-divider::after {
        content: '';
        flex: 1;
    }

    body.dark-mode .or-divider::before, body.dark-mode .or-divider::after {
        border-bottom: 1px solid #4b5563;
    }

    body.light-mode .or-divider::before, body.light-mode .or-divider::after {
        border-bottom: 1px solid #e5e7eb;
    }

    .or-divider::before {
        margin-right: 6px;
    }

    .or-divider::after {
        margin-left: 6px;
    }

    .social-icon {
        margin-right: 5px;
        font-size: 12px;
    }

    .register-link {
        margin-top: 8px;
        text-align: center;
        font-size: 0.75rem;
    }

    body.dark-mode .register-link {
        color: #d1d5db;
    }

    body.light-mode .register-link {
        color: #6b7280;
    }

    body.dark-mode .register-link a {
        color: #a78bfa;
        font-weight: 600;
        text-decoration: none;
    }

    body.light-mode .register-link a {
        color: #6366f1;
        font-weight: 600;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    body.dark-mode .alert-danger {
        background-color: rgba(220, 38, 38, 0.2);
        color: #fca5a5;
        border-color: rgba(220, 38, 38, 0.3);
    }

    .mb-3 {
        margin-bottom: 6px !important;
    }

    .mt-2 {
        margin-top: 6px !important;
    }

    .mb-2 {
        margin-bottom: 4px !important;
    }

    .alert {
        padding: 0.25rem 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.7rem;
    }

    .card-body {
        padding: 0;
    }

    .compact-form .row > * {
        padding-right: 4px;
        padding-left: 4px;
    }

    .theme-toggle {
        position: absolute;
        top: 10px;
        right: 10px;
        background: transparent;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        z-index: 100;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    body.dark-mode .theme-toggle {
        color: #f3f4f6;
        background-color: rgba(31, 41, 55, 0.5);
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
    }

    body.light-mode .theme-toggle {
        color: #1f2937;
        background-color: rgba(229, 231, 235, 0.5);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    body.dark-mode .theme-toggle:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: scale(1.05);
    }

    body.light-mode .theme-toggle:hover {
        background-color: rgba(0, 0, 0, 0.1);
        transform: scale(1.05);
    }

    .sun-icon, .moon-icon {
        filter: drop-shadow(0 0 1px rgba(0, 0, 0, 0.3));
    }
    
    body.dark-mode .sun-icon {
        color: #fbbf24;
        filter: drop-shadow(0 0 3px rgba(251, 191, 36, 0.5));
    }
    
    body.light-mode .moon-icon {
        color: #6366f1;
        filter: drop-shadow(0 0 3px rgba(99, 102, 241, 0.3));
    }

    @media screen and (max-height: 650px) {
        .login-image {
            width: 35px;
            margin-bottom: 4px;
        }
        
        .card-header-custom {
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        
        .card-custom {
            padding: 12px 14px;
        }
        
        .mb-3 {
            margin-bottom: 4px !important;
        }
    }

    @media screen and (max-height: 550px) {
        .login-image {
            display: none;
        }
        
        .or-divider {
            margin: 4px 0;
        }
        
        .btn-social {
            padding: 4px 8px;
            margin-bottom: 4px;
        }
        
        .btn-primary {
            padding: 4px 8px;
        }
    }
</style>

<button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sun-icon"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
</button>

<div class="login-container">
    <div class="card card-custom">
        <div class="text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Login Icon" class="login-image">
        </div>

        <div class="card-header card-header-custom">
            {{ __('Sign in to MySecureVault') }}
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Social Login Buttons -->
            <a href="{{ route('social.login', 'google') }}" class="btn btn-social btn-google">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" class="social-icon"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                {{ __('Google') }}
            </a>
            <a href="{{ route('social.login', 'github') }}" class="btn btn-social btn-github">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white" class="social-icon"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                {{ __('GitHub') }}
            </a>

            <div class="or-divider">{{ __('OR') }}</div>

            <form method="POST" action="{{ route('login') }}" class="compact-form">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-2 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Sign In') }}
                    </button>
                </div>

                <div class="d-flex justify-content-center mt-2">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot?') }}
                        </a>
                    @endif
                </div>
            </form>

            <div class="register-link">
                {{ __("New user?") }} <a href="{{ route('register') }}">{{ __('Register') }}</a>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/theme-switcher.js') }}"></script>
@endsection