@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="display-4 fw-bold mb-3">Welcome to GINCE Hotel</h1>
            <p class="lead mb-4">Experience luxury and comfort like never before</p>
            <a href="#rooms" class="btn btn-lg btn-primary">
                <i class="fas fa-search me-2"></i>Browse Rooms
            </a>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Search Section -->
    <div class="card mb-5">
        <div class="card-body p-4">
            <h2 class="fs-4 mb-4 text-center">Find Your Perfect Room</h2>
            <form action="{{ route('home') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="check_in" class="form-label fw-medium">Check in</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-secondary"></i></span>
                                <input type="date" class="form-control" id="check_in" name="check_in" 
                                       value="{{ $checkIn ?? date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="check_out" class="form-label fw-medium">Check out</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-secondary"></i></span>
                                <input type="date" class="form-control" id="check_out" name="check_out" 
                                       value="{{ $checkOut ?? date('Y-m-d', strtotime('+1 day')) }}" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-search me-2"></i>Find Available Rooms
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- About Section -->
    <div class="row align-items-center my-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                 alt="GINCE Hotel Lobby" class="img-fluid rounded shadow">
        </div>
        <div class="col-lg-6">
            <h2 class="fs-1 fw-bold mb-4">Experience the Ultimate <span class="text-secondary">Luxury</span></h2>
            <p class="lead mb-4">At GINCE Hotel, we offer exceptional service, luxurious accommodations, and unforgettable experiences for our guests.</p>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-concierge-bell fs-3 text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">Premium Service</h5>
                            <p class="text-muted">24/7 concierge and room service for all your needs.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-utensils fs-3 text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">Fine Dining</h5>
                            <p class="text-muted">Exquisite dining experiences with world-class chefs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Room Section -->
    <div id="rooms" class="my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fs-1 fw-bold mb-0">Our <span class="text-secondary">Rooms</span></h2>
            @if($rooms->isNotEmpty())
            <span class="badge bg-secondary">{{ $rooms->count() }} Available</span>
            @endif
        </div>
        
        @if($rooms->isEmpty())
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="fas fa-info-circle fs-4 me-3"></i>
                <div>
                    No rooms available for the selected dates. Please try different dates.
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($rooms as $room)
                    <div class="col">
                        <div class="card h-100 room-card">
                            <div class="position-relative">
                                <img src="{{ $room->image ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80' }}" 
                                     alt="{{ $room->name }}" 
                                     class="card-img-top room-img">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-primary rounded-pill px-3 py-2">${{ $room->price }}/night</span>
                                </div>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title fs-5 fw-semibold">{{ $room->name }}</h3>
                                <p class="card-text text-muted mb-3">{{ Str::limit($room->description, 100) }}</p>
                                
                                <div class="room-features d-flex flex-wrap mb-3 mt-auto">
                                    <span class="me-3 mb-2" title="Max occupancy">
                                        <i class="fas fa-user text-secondary me-1"></i> {{ $room->capacity }} Guests
                                    </span>
                                    <span class="me-3 mb-2" title="Room size">
                                        <i class="fas fa-ruler-combined text-secondary me-1"></i> 30m²
                                    </span>
                                    <span class="mb-2" title="Free WiFi">
                                        <i class="fas fa-wifi text-secondary me-1"></i> Free WiFi
                                    </span>
                                </div>
                                
                                <div class="d-grid">
                                    @auth
                                        <a href="{{ route('bookings.create', ['room' => $room, 'check_in' => $checkIn, 'check_out' => $checkOut]) }}" class="btn btn-primary">
                                            <i class="fas fa-calendar-check me-2"></i>Book Now
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login to Book
                                        </a>
                                        <div class="text-center mt-2">
                                            <small class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none fw-medium">Register here</a></small>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    
    <!-- Amenities Section -->
    <div class="my-5 pt-5">
        <h2 class="fs-1 fw-bold text-center mb-5">Our <span class="text-secondary">Amenities</span></h2>
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="text-center">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-swimmer fs-2 text-secondary"></i>
                    </div>
                    <h5 class="fw-bold">Swimming Pool</h5>
                    <p class="text-muted small">Indoor and outdoor pools</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-spa fs-2 text-secondary"></i>
                    </div>
                    <h5 class="fw-bold">Spa & Wellness</h5>
                    <p class="text-muted small">Relaxing treatments</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-dumbbell fs-2 text-secondary"></i>
                    </div>
                    <h5 class="fw-bold">Fitness Center</h5>
                    <p class="text-muted small">Modern equipment</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-wifi fs-2 text-secondary"></i>
                    </div>
                    <h5 class="fw-bold">Free WiFi</h5>
                    <p class="text-muted small">High-speed internet</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Testimonials Section -->
    <div class="my-5 py-5 bg-light rounded">
        <div class="container">
            <h2 class="fs-1 fw-bold text-center mb-5">What Our <span class="text-secondary">Guests Say</span></h2>
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-body p-4">
                            <div class="d-flex mb-4">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text fst-italic">"The service at GINCE Hotel was exceptional! The staff was attentive and went above and beyond to make our stay comfortable."</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="https://randomuser.me/api/portraits/women/45.jpg" class="rounded-circle me-3" width="50" alt="Guest">
                                <div>
                                    <h6 class="mb-0 fw-bold">Sarah Johnson</h6>
                                    <small class="text-muted">New York, USA</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-body p-4">
                            <div class="d-flex mb-4">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text fst-italic">"The rooms were luxurious and the beds were so comfortable! I had the best sleep in years. Will definitely be back!"</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle me-3" width="50" alt="Guest">
                                <div>
                                    <h6 class="mb-0 fw-bold">Michael Chen</h6>
                                    <small class="text-muted">Toronto, Canada</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-body p-4">
                            <div class="d-flex mb-4">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text fst-italic">"The restaurant offered an amazing dining experience. The chef's special was delightful and the ambiance was perfect!"</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle me-3" width="50" alt="Guest">
                                <div>
                                    <h6 class="mb-0 fw-bold">Emma Rodriguez</h6>
                                    <small class="text-muted">London, UK</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="card bg-dark text-white my-5 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
             class="card-img" alt="Hotel Pool" style="opacity: 0.4; object-fit: cover; height: 300px;">
        <div class="card-img-overlay d-flex align-items-center justify-content-center text-center">
            <div>
                <h2 class="card-title display-5 fw-bold mb-3">Ready for an Unforgettable Stay?</h2>
                <p class="card-text lead mb-4">Book your room now and experience the luxury of GINCE Hotel.</p>
                <a href="#rooms" class="btn btn-lg btn-primary">
                    <i class="fas fa-calendar-check me-2"></i>Book Now
                </a>
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
</style>
@endsection