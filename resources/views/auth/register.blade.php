@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-5">
                <h1 class="fs-2 fw-bold">Join <span class="text-secondary">GINCE Hotel</span></h1>
                <p class="text-muted">Create an account to book rooms and access exclusive offers</p>
            </div>
            
            <div class="card shadow border-0">
                <div class="card-header py-3">
                    <h4 class="mb-0 fw-bold">{{ __('Register') }}</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-medium">{{ __('Name') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user text-secondary"></i></span>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium">{{ __('Email Address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope text-secondary"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">{{ __('Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock text-secondary"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create a password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-text">Password must be at least 8 characters</div>
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-medium">{{ __('Confirm Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock text-secondary"></i></span>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="text-secondary">Terms of Service</a> and <a href="#" class="text-secondary">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2">
                                <i class="fas fa-user-plus me-2"></i>{{ __('Register') }}
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-0">{{ __('Already have an account?') }} <a href="{{ route('login') }}" class="fw-semibold text-secondary">{{ __('Login') }}</a></p>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="small text-muted">By registering, you'll receive exclusive offers and updates from GINCE Hotel</p>
            </div>
        </div>
    </div>
</div>
@endsection 