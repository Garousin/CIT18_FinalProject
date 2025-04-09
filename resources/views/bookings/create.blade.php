@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <i class="fas fa-calendar-plus me-2 text-primary"></i>
                <span>{{ __('Book Your Stay') }}</span>
            </div>
            
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <img src="{{ $room->image ?? 'https://via.placeholder.com/600x400' }}" alt="{{ $room->name }}" class="img-fluid rounded">
                    </div>
                    <div class="col-md-8">
                        <h2 class="fs-4 fw-bold mb-3">{{ $room->name }}</h2>
                        <p class="text-muted mb-3">{{ $room->description }}</p>
                        <div class="d-flex mb-3">
                            <div class="me-4" title="Max occupancy"><i class="fas fa-user me-1"></i> 2 Guests</div>
                            <div class="me-4" title="Room size"><i class="fas fa-expand-arrows-alt me-1"></i> 28m²</div>
                            <div title="Free WiFi"><i class="fas fa-wifi me-1"></i> Free WiFi</div>
                        </div>
                        <div class="price-tag mb-3">
                            <span class="badge bg-primary px-3 py-2 rounded-pill fs-5">${{ $room->price }}/night</span>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="check_in" class="form-label fw-medium">Check-in Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-calendar-check text-primary"></i></span>
                                <input type="date" id="check_in" name="check_in" 
                                       class="form-control @error('check_in') is-invalid @enderror" 
                                       min="{{ now()->format('Y-m-d') }}" required>
                                @error('check_in')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text"><small>Check-in time is 2:00 PM</small></div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="check_out" class="form-label fw-medium">Check-out Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-calendar-minus text-primary"></i></span>
                                <input type="date" id="check_out" name="check_out" 
                                       class="form-control @error('check_out') is-invalid @enderror" 
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
                            <label for="guests" class="form-label fw-medium">Number of Guests</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-users text-primary"></i></span>
                                <select id="guests" name="guests" class="form-select">
                                    <option value="1">1 Guest</option>
                                    <option value="2" selected>2 Guests</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="special_requests" class="form-label fw-medium">Special Requests</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-concierge-bell text-primary"></i></span>
                                <textarea id="special_requests" name="special_requests" class="form-control" rows="1" placeholder="Any special requests?"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h3 class="fs-5 fw-semibold mb-3">Price Summary</h3>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Room Rate:</span>
                                <span>${{ $room->price }} / night</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Duration:</span>
                                <span id="duration">1 night</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span id="total">${{ $room->price }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-3">
                            <i class="fas fa-check-circle me-2"></i>Complete Booking
                        </button>
                    </div>
                </form>
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
                    totalText.textContent = `$${roomPrice * nights}`;
                } else {
                    durationText.textContent = '0 nights';
                    totalText.textContent = '$0';
                }
            }
        };
        
        checkInInput.addEventListener('change', calculateDuration);
        checkOutInput.addEventListener('change', calculateDuration);
    });
</script>
@endsection