@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="mb-5">
        <h1 class="fs-2 fw-bold mb-2">Welcome to Our Hotel</h1>
        <p class="text-muted">Find and book your perfect room for a comfortable stay</p>
    </div>
    
    <!-- Room filtering options -->
    <div class="card mb-5">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="checkIn" class="form-label fw-medium">Check in</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-muted"></i></span>
                            <input type="date" class="form-control" id="checkIn" min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="checkOut" class="form-label fw-medium">Check out</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-muted"></i></span>
                            <input type="date" class="form-control" id="checkOut" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Find Available Rooms
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <h2 class="fs-3 fw-bold mb-4">Our Rooms</h2>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
        @foreach($rooms as $room)
            <div class="col">
                <div class="card h-100 room-card">
                    <img src="{{ $room->image ?? 'https://via.placeholder.com/600x400' }}" 
                         alt="{{ $room->name }}" 
                         class="card-img-top room-img">
                    
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h3 class="card-title fs-5 fw-semibold">{{ $room->name }}</h3>
                            <span class="badge bg-primary rounded-pill px-3 py-2">${{ $room->price }}/night</span>
                        </div>
                        
                        <p class="card-text text-muted mb-3">{{ Str::limit($room->description, 100) }}</p>
                        
                        <div class="d-flex justify-content-between mt-auto">
                            <div class="room-features d-flex">
                                <span class="me-3" title="Max occupancy"><i class="fas fa-user me-1"></i> 2</span>
                                <span class="me-3" title="Room size"><i class="fas fa-expand-arrows-alt me-1"></i> 28m²</span>
                                <span title="Free WiFi"><i class="fas fa-wifi me-1"></i> WiFi</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-top-0 pt-0">
                        @auth
                            <a href="{{ route('bookings.create', $room) }}" class="btn btn-primary w-100">
                                <i class="fas fa-calendar-check me-2"></i>Book Now
                            </a>
                        @else
                            <div class="d-grid gap-2">
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Book
                                </a>
                                <div class="text-center">
                                    <small class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none fw-medium">Register here</a></small>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    @guest
    <div class="card mb-5">
        <div class="card-body text-center py-4">
            <div class="mb-3">
                <i class="fas fa-user-circle fa-4x text-primary"></i>
            </div>
            <h3 class="fs-4 fw-bold mb-3">Create an Account to Book Your Stay</h3>
            <p class="text-muted mb-4">Sign up now to book rooms and access special offers</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-primary px-4">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary px-4">
                    <i class="fas fa-user-plus me-2"></i>Register
                </a>
            </div>
        </div>
    </div>
    @endguest
    
    <div class="mt-5 text-center">
        <h3 class="fs-4 fw-bold mb-4">Why Choose Our Hotel?</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-box text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                    </div>
                    <h4 class="fs-5 fw-semibold">Prime Location</h4>
                    <p class="text-muted">Located in the heart of the city with easy access to attractions</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-concierge-bell fa-2x text-primary"></i>
                    </div>
                    <h4 class="fs-5 fw-semibold">Excellent Service</h4>
                    <p class="text-muted">24/7 customer service to ensure your stay is comfortable</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-utensils fa-2x text-primary"></i>
                    </div>
                    <h4 class="fs-5 fw-semibold">Fine Dining</h4>
                    <p class="text-muted">Enjoy gourmet meals prepared by our world-class chefs</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .room-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .room-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .room-img {
        height: 200px;
        object-fit: cover;
    }
    .feature-box {
        background-color: white;
        border-radius: 0.8rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }
    .feature-box:hover {
        transform: translateY(-5px);
    }
</style>
@endsection