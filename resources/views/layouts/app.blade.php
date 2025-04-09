<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GINCE Hotel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e67e22;
            --accent-color: #3498db;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            background-color: #f5f5f5;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }
        
        .navbar-brand span {
            color: var(--secondary-color);
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: white !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--primary-color) !important;
            position: relative;
        }
        
        .nav-link:hover {
            color: var(--secondary-color) !important;
        }
        
        .nav-link.active::after {
            content: '';
            display: block;
            width: 50%;
            height: 2px;
            background-color: var(--secondary-color);
            bottom: -2px;
            left: 25%;
            position: absolute;
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-primary:hover {
            background-color: #d35400;
            border-color: #d35400;
        }
        
        .btn-outline-primary {
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .card {
            border-radius: 10px;
            overflow: hidden;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }
        
        .hero-section {
            background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            position: relative;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .badge {
            font-weight: 500;
            padding: 6px 12px;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .bg-secondary {
            background-color: var(--secondary-color) !important;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .text-secondary {
            color: var(--secondary-color) !important;
        }
        
        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-hotel text-secondary me-2"></i>
                    GINCE <span>Hotel</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i>{{ __('Home') }}
                            </a>
                        </li>
                        @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('bookings.index') ? 'active' : '' }}" href="{{ route('bookings.index') }}">
                                <i class="fas fa-calendar-check me-1"></i>{{ __('My Bookings') }}
                            </a>
                        </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-1"></i>{{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-1"></i>{{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->is_admin)
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>{{ __('Admin Dashboard') }}
                                    </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
        
        <footer class="mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5 class="mb-3">GINCE Hotel</h5>
                        <p class="mb-3">Experience luxury and comfort at GINCE Hotel. We provide exceptional service and memorable stays for all our guests.</p>
                        <div class="social-links">
                            <a href="#" class="me-2 text-white"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="me-2 text-white"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="me-2 text-white"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5 class="mb-3">Quick Links</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="{{ route('home') }}" class="text-white text-decoration-none">Home</a></li>
                            @auth
                            <li class="mb-2"><a href="{{ route('bookings.index') }}" class="text-white text-decoration-none">My Bookings</a></li>
                            @endauth
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none">About Us</a></li>
                            <li class="mb-2"><a href="#" class="text-white text-decoration-none">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5 class="mb-3">Contact Info</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Hotel Street, City</li>
                            <li class="mb-2"><i class="fas fa-phone-alt me-2"></i> +1 (123) 456-7890</li>
                            <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@gincehotel.com</li>
                        </ul>
                    </div>
                </div>
                <hr class="my-4 bg-light">
                <div class="text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} GINCE Hotel. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>