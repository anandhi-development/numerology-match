@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark mb-1">{{ __('messages.create_account') }}</h3>
                    <p class="text-muted small">Enter your personal details to get started</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- First & Last Name -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">{{ __('messages.first_name') }}</label>
                            <input type="text" name="first_name" class="form-control rounded-3 py-2 @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="Anandhi" required autofocus>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">{{ __('messages.last_name') }}</label>
                            <input type="text" name="last_name" class="form-control rounded-3 py-2 @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="V">
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">{{ __('messages.email') }}</label>
                        <input type="email" name="email" class="form-control rounded-3 py-2 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="anandhi@example.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">{{ __('messages.password') }}</label>
                        <input type="password" name="password" class="form-control rounded-3 py-2 @error('password') is-invalid @enderror" placeholder="••••••••" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary">{{ __('messages.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-3 py-2" placeholder="••••••••" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-brand-primary btn-lg py-2">
                            {{ __('messages.sign_up') }}
                        </button>
                    </div>

                    <!-- Already have account -->
                    <div class="text-center text-muted small">
                        {{ __('messages.already_have_account') }}
                        <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none ms-1">
                            {{ __('messages.login') }}
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
