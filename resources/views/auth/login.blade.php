@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark mb-1">{{ __('messages.login_title') }}</h3>
                    <p class="text-muted small">Access your numerology compatibility reports</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">{{ __('messages.email') }}</label>
                        <input type="email" name="email" class="form-control rounded-3 py-2 @error('email') is-invalid @enderror" value="{{ old('email', 'anandhi@example.com') }}" placeholder="anandhi@example.com" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-semibold text-secondary mb-0">{{ __('messages.password') }}</label>
                            <a href="#" class="text-muted small text-decoration-none">{{ __('messages.forgot_password') }}</a>
                        </div>
                        <input type="password" name="password" class="form-control rounded-3 py-2 @error('password') is-invalid @enderror" placeholder="••••••••" value="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember me -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                        <label class="form-check-label small text-secondary" for="rememberMe">
                            Remember this device
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-brand-primary btn-lg py-2">
                            {{ __('messages.login') }}
                        </button>
                    </div>

                    <!-- Sign Up Link -->
                    <div class="text-center text-muted small">
                        {{ __('messages.dont_have_account') }}
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none ms-1">
                            {{ __('messages.sign_up') }}
                        </a>
                    </div>

                    <!-- Demo credentials hint for assessment review -->
                    <div class="mt-4 pt-3 border-top text-center">
                        <div class="badge bg-light text-dark p-2 text-start w-100" style="font-size: 0.75rem; border: 1px dashed #cbd5e1;">
                            <strong>Demo Credentials:</strong><br>
                            &bull; <strong>User:</strong> anandhi@gmail.com / anandhi123<br>
                            &bull; <strong>Admin:</strong> admin@gmail.com / admin123
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
