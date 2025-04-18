@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 60px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('email_exists'))
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                {{ session('email_exists') }}
                <a href="{{ route('password.request') }}" class="alert-link">Click here to reset your password</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('registration_success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('registration_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card shadow" style="border: none; border-radius: 12px;">
                <div class="card-header text-center" style="background-color: #007bff; color: white; font-size: 24px; font-weight: 600; border-radius: 12px 12px 0 0;">
                    {{ __('Register') }}
                </div>

                <div class="card-body" style="background-color: #f9f9f9; padding: 40px;">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="row mb-4">
                            <label for="name" class="col-md-4 col-form-label text-md-end" style="font-weight: 500;">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control shadow-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus style="border-radius: 8px;">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-4">
                            <label for="email" class="col-md-4 col-form-label text-md-end" style="font-weight: 500;">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control shadow-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" style="border-radius: 8px;">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="row mb-4">
                            <label for="password" class="col-md-4 col-form-label text-md-end" style="font-weight: 500;">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control shadow-sm @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="border-radius: 8px;">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="row mb-4">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end" style="font-weight: 500;">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control shadow-sm" name="password_confirmation" required autocomplete="new-password" style="border-radius: 8px;">
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 8px; font-weight: 600;">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                        {{-- Already have account --}}
                        <div class="row mt-4">
                            <div class="col-md-6 offset-md-4 text-center">
                                <a href="{{ route('login') }}" style="text-decoration: none; font-size: 14px; color: #007bff;">Already have an account? Login here</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection