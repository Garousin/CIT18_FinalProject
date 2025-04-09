<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hotel Booking System') }} Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #3f51b5;
            --primary-dark: #303f9f;
            --primary-light: #7986cb;
            --accent-color: #ff4081;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            color: var(--text-color);
            background-color: var(--light-gray);
        }
        
        /* Admin sidebar */
        .admin-sidebar {
            width: 280px;
            background-color: var(--primary-color);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar-brand {
            padding: 1.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
        }
        
        .sidebar-brand i {
            margin-right: 0.75rem;
            font-size: 1.75rem;
        }
        
        .sidebar-menu {
            padding: 0;
            list-style: none;
            margin-top: 1.5rem;
        }
        
        .sidebar-menu .item {
            margin-bottom: 0.5rem;
        }
        
        .sidebar-menu .item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            transition: 0.3s;
            font-weight: 500;
        }
        
        .sidebar-menu .item a:hover,
        .sidebar-menu .item a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar-menu .item i {
            margin-right: 0.75rem;
            width: 24px;
            text-align: center;
        }
        
        /* Main content */
        .admin-content {
            flex: 1;
            margin-left: 280px;
            padding: 0;
            width: calc(100% - 280px);
            transition: all 0.3s;
        }
        
        .admin-header {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .admin-main {
            padding: 2rem;
        }
        
        /* Mobile responsive */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                margin-left: -280px;
            }
            
            .admin-sidebar.active {
                margin-left: 0;
            }
            
            .admin-content {
                width: 100%;
                margin-left: 0;
            }
            
            .admin-content.active {
                margin-left: 280px;
                width: calc(100% - 280px);
            }
        }
        
        /* Cards styling */
        .card {
            border: none;
            border-radius: 0.8rem;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
            padding: 1.25rem 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Tables styling */
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: var(--light-gray);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: var(--text-color);
            padding: 1rem;
            white-space: nowrap;
        }
        
        /* Stats card */
        .stat-card {
            border-radius: 0.8rem;
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            background-color: white;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            background-color: rgba(63, 81, 181, 0.1);
            color: var(--primary-color);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .stat-title {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0;
        }
        
        /* Forms */
        .form-control, .form-select {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 0.875rem;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(63, 81, 181, 0.25);
            border-color: var(--primary-color);
        }
        
        .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        /* Buttons */
        .btn {
            border-radius: 0.5rem;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="wrapper d-flex">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="fas fa-hotel"></i>
                <span>Hotel Admin</span>
            </a>
            
            <ul class="sidebar-menu">
                <li class="item">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="item">
                    <a href="{{ route('admin.rooms.index') }}" class="{{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                        <i class="fas fa-bed"></i>
                        <span>Rooms</span>
                    </a>
                </li>
                <li class="item">
                    <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Bookings</span>
                    </a>
                </li>
                <li class="item">
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="item">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        <span>Back to Website</span>
                    </a>
                </li>
                <li class="item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </aside>

        <!-- Main content -->
        <div class="admin-content">
            <header class="admin-header d-flex justify-content-between align-items-center">
                <div>
                    <button id="sidebarToggle" class="btn btn-sm d-lg-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h5 class="mb-0 d-inline-block ms-2">@yield('title', 'Admin Dashboard')</h5>
                </div>
                <div>
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            
            <main class="admin-main">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar on mobile
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.admin-sidebar');
            const content = document.querySelector('.admin-content');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    content.classList.toggle('active');
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html> 