@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-5">
                <h1 class="fs-2 fw-bold">Welcome to <span class="text-secondary">GINCE Hotel</span></h1>
                <p class="text-muted">Sign in to access your bookings and account</p>
            </div>
            
            <div class="card shadow border-0">
                <div class="card-header py-3">
                    <h4 class="mb-0 fw-bold">{{ __('Login') }}</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium">{{ __('Email Address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope text-secondary"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label fw-medium mb-0">{{ __('Password') }}</label>
                                <a href="#" class="text-secondary text-decoration-none small">Forgot Password?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-key text-secondary"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2">
                                <i class="fas fa-sign-in-alt me-2"></i>{{ __('Login') }}
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-0">{{ __('Don\'t have an account?') }} <a href="{{ route('register') }}" class="fw-semibold text-secondary">{{ __('Register') }}</a></p>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="small text-muted">By logging in, you agree to our <a href="#" class="text-secondary">Terms of Service</a> and <a href="#" class="text-secondary">Privacy Policy</a></p>
            </div>
        </div>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3">
    <div class="bg-primary text-white rounded-pill shadow px-4 py-2 d-inline-flex align-items-center">
        <i class="fas fa-concierge-bell me-2"></i>
        <span class="fw-medium">Need help? Contact us</span>
    </div>
</div>
@endsection 