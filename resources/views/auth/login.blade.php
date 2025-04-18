@extends('layouts.app')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .card-custom {
        width: 100%;
        max-width: 400px;
        border: none;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        padding: 40px 32px;
        transition: transform 0.2s ease;
    }

    .card-custom:hover {
        transform: translateY(-5px);
    }

    .card-header-custom {
        text-align: center;
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 32px;
        letter-spacing: -0.5px;
    }

    .login-image {
        display: block;
        margin: 0 auto 24px auto;
        width: 64px;
        height: auto;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }

    .form-label {
        font-weight: 600;
        color: #4a5568;
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        border: 1.5px solid #e2e8f0;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        background-color: #ffffff;
    }

    .btn-primary {
        background-color: #3b82f6;
        border: none;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 12px;
        transition: all 0.2s ease;
        width: auto;
        min-width: 120px;
    }

    .btn-primary:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }

    .btn-link {
        color: #64748b;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .btn-link:hover {
        color: #3b82f6;
        text-decoration: none;
    }

    .form-check-input {
        border-radius: 4px;
        border: 1.5px solid #cbd5e1;
    }

    .form-check-input:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    .form-check-label {
        color: #64748b;
        font-size: 0.9rem;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 6px;
    }

    @media (max-width: 480px) {
        .card-custom {
            padding: 32px 24px;
        }
    }
</style>

<div class="login-container">
    <div class="card card-custom">
        <div class="text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Login Icon" class="login-image">
        </div>

        <div class="card-header card-header-custom">
            {{ __('Login to Your Account') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
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

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection