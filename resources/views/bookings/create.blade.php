@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="mb-4">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Rooms') }}
                </a>
            </div>
            
            <div class="card shadow border-0">
                <div class="card-header py-3">
                    <h4 class="mb-0 fw-bold">{{ __('Book Your Stay') }}</h4>
                </div>
                
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <img src="{{ $room->image ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80' }}" 
                                 alt="{{ $room->name }}" class="img-fluid rounded shadow">
                        </div>
                        <div class="col-md-8">
                            <h2 class="fs-4 fw-bold mb-3">{{ $room->name }}</h2>
                            <p class="text-muted mb-3">{{ $room->description }}</p>
                            <div class="d-flex flex-wrap mb-3">
                                <span class="me-4 mb-2" title="Max occupancy">
                                    <i class="fas fa-user text-secondary me-1"></i> {{ $room->capacity }} Guests
                                </span>
                                <span class="me-4 mb-2" title="Room size">
                                    <i class="fas fa-ruler-combined text-secondary me-1"></i> 30m²
                                </span>
                                <span class="mb-2" title="Free WiFi">
                                    <i class="fas fa-wifi text-secondary me-1"></i> Free WiFi
                                </span>
                            </div>
                            <div class="price-tag mb-3">
                                <span class="badge bg-primary rounded-pill px-3 py-2 fs-5">${{ number_format($room->price, 2) }}/night</span>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="check_in" class="form-label fw-medium">{{ __('Check-in Date') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-calendar-check text-secondary"></i></span>
                                    <input type="date" id="check_in" name="check_in" 
                                           class="form-control @error('check_in') is-invalid @enderror" 
                                           value="{{ $checkIn }}"
                                           min="{{ now()->format('Y-m-d') }}" required>
                                    @error('check_in')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text"><small>Check-in time is 2:00 PM</small></div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="check_out" class="form-label fw-medium">{{ __('Check-out Date') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-calendar-minus text-secondary"></i></span>
                                    <input type="date" id="check_out" name="check_out" 
                                           class="form-control @error('check_out') is-invalid @enderror" 
                                           value="{{ $checkOut }}"
                                           min="{{ now()->addDay()->format('Y-m-d') }}" required>
                                    @error('check_out')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text"><small>Check-out time is 11:00 AM</small></div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="guests" class="form-label fw-medium">{{ __('Number of Guests') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-users text-secondary"></i></span>
                                    <select id="guests" name="guests" class="form-select">
                                        @for ($i = 1; $i <= $room->capacity; $i++)
                                            <option value="{{ $i }}" {{ $i == 2 ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="special_requests" class="form-label fw-medium">{{ __('Special Requests') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-concierge-bell text-secondary"></i></span>
                                    <textarea id="special_requests" name="special_requests" class="form-control" rows="1" placeholder="Any special requests?"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card bg-light mb-4 border-0">
                            <div class="card-body p-4">
                                <h3 class="fs-5 fw-semibold mb-3">{{ __('Price Summary') }}</h3>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ __('Room Rate:') }}</span>
                                    <span>${{ number_format($room->price, 2) }} / night</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ __('Duration:') }}</span>
                                    <span id="duration">1 night</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>{{ __('Total:') }}</span>
                                    <span id="total" class="text-secondary">${{ number_format($room->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-3">
                                <i class="fas fa-check-circle me-2"></i>{{ __('Complete Booking') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-shield-alt text-secondary fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">{{ __('Flexible Cancellation Policy') }}</h5>
                            <p class="mb-0 text-muted">Free cancellation up to 24 hours before check-in. Cancel before then for a full refund.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate duration and total price
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const durationText = document.getElementById('duration');
        const totalText = document.getElementById('total');
        const roomPrice = {{ $room->price }};
        
        const calculateDuration = () => {
            if (checkInInput.value && checkOutInput.value) {
                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);
                const diffTime = Math.abs(checkOut - checkIn);
                const nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (nights > 0) {
                    durationText.textContent = nights === 1 ? '1 night' : `${nights} nights`;
                    totalText.textContent = `$${(roomPrice * nights).toFixed(2)}`;
                } else {
                    durationText.textContent = '0 nights';
                    totalText.textContent = '$0.00';
                }
            }
        };
        
        checkInInput.addEventListener('change', calculateDuration);
        checkOutInput.addEventListener('change', calculateDuration);
        
        // Initialize calculation
        calculateDuration();
    });
</script>
@endsection