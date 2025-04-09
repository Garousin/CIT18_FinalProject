@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="mb-4">
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Bookings') }}
                </a>
            </div>
            
            <div class="card shadow border-0">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-receipt me-2 text-secondary"></i>
                        <h4 class="fs-5 fw-bold mb-0">{{ __('Booking Details') }}</h4>
                    </div>
                    <div>
                        @if($booking->status === 'confirmed')
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>{{ __('Confirmed') }}
                            </span>
                        @elseif($booking->status === 'pending')
                            <span class="badge bg-warning rounded-pill px-3 py-2">
                                <i class="fas fa-clock me-1"></i>{{ __('Pending') }}
                            </span>
                        @elseif($booking->status === 'pending_payment')
                            <span class="badge bg-info rounded-pill px-3 py-2">
                                <i class="fas fa-credit-card me-1"></i>{{ __('Payment Required') }}
                            </span>
                        @elseif($booking->status === 'cancelled')
                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                <i class="fas fa-times-circle me-1"></i>{{ __('Cancelled') }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-5 mb-4 mb-md-0">
                            <img src="{{ $booking->room->image ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80' }}" 
                                 alt="{{ $booking->room->name }}" 
                                 class="img-fluid rounded shadow mb-3">
                                 
                            <h3 class="fs-5 fw-bold">{{ $booking->room->name }}</h3>
                            <p class="text-muted">{{ Str::limit($booking->room->description, 150) }}</p>
                            
                            <div class="d-flex flex-wrap">
                                <span class="me-4 mb-2" title="Max occupancy">
                                    <i class="fas fa-user text-secondary me-1"></i> {{ $booking->room->capacity ?? 2 }} Guests
                                </span>
                                <span class="mb-2" title="Free WiFi">
                                    <i class="fas fa-wifi text-secondary me-1"></i> Free WiFi
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-7">
                            <div class="card bg-light border-0 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="card-title fs-5 fw-bold mb-3">{{ __('Reservation Information') }}</h4>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <div class="mb-3">
                                                <span class="d-block text-muted small">{{ __('Booking ID') }}</span>
                                                <span class="fw-bold">#{{ $booking->id }}</span>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <span class="d-block text-muted small">{{ __('Booking Date') }}</span>
                                                <span class="fw-bold">{{ $booking->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="mb-3">
                                                <span class="d-block text-muted small">{{ __('Guest Name') }}</span>
                                                <span class="fw-bold">{{ $booking->user->name }}</span>
                                            </div>
                                            
                                            <div>
                                                <span class="d-block text-muted small">{{ __('Email') }}</span>
                                                <span class="fw-bold">{{ $booking->user->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="row mb-2">
                                        <div class="col-md-6 mb-3">
                                            <div>
                                                <span class="d-block text-muted small">{{ __('Check-in') }}</span>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-check text-success me-2"></i>
                                                    <span class="fw-bold">{{ $booking->check_in->format('D, M d, Y') }}</span>
                                                </div>
                                                <small class="text-muted">{{ __('After 2:00 PM') }}</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div>
                                                <span class="d-block text-muted small">{{ __('Check-out') }}</span>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-minus text-danger me-2"></i>
                                                    <span class="fw-bold">{{ $booking->check_out->format('D, M d, Y') }}</span>
                                                </div>
                                                <small class="text-muted">{{ __('Before 11:00 AM') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <span class="d-block text-muted small">{{ __('Duration') }}</span>
                                        <span class="fw-bold">{{ $booking->check_in->diffInDays($booking->check_out) }} {{ __('night(s)') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card bg-white border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <h4 class="card-title fs-5 fw-bold mb-3">{{ __('Payment Summary') }}</h4>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('Room Rate') }}:</span>
                                        <span>${{ number_format($booking->room->price, 2) }} / {{ __('night') }}</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('Duration') }}:</span>
                                        <span>{{ $booking->check_in->diffInDays($booking->check_out) }} {{ __('night(s)') }}</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('Subtotal') }}:</span>
                                        <span>${{ number_format($booking->total_price, 2) }}</span>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>{{ __('Total') }}:</span>
                                        <span class="fs-5 text-secondary">${{ number_format($booking->total_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            @if($booking->status === 'pending_payment')
                            <div class="d-grid">
                                <a href="{{ route('bookings.payment', $booking) }}" class="btn btn-primary py-3">
                                    <i class="fas fa-credit-card me-2"></i>{{ __('Proceed to Payment') }}
                                </a>
                            </div>
                            @elseif($booking->status === 'confirmed')
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="fas fa-check-circle fs-5 me-3"></i>
                                <div>
                                    {{ __('Payment completed successfully!') }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Information -->
            <div class="card mt-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-info-circle fs-4 text-secondary me-3"></i>
                        <h5 class="fw-bold mb-0">{{ __('Important Information') }}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">{{ __('Check-in Instructions') }}</h6>
                            <p class="text-muted small mb-3">Please present your booking confirmation and a valid ID at the reception desk upon arrival. Our front desk is open 24/7.</p>
                            
                            <h6 class="fw-bold mb-2">{{ __('Check-out Information') }}</h6>
                            <p class="text-muted small mb-0">Express check-out is available. Please return your room key to the front desk.</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">{{ __('Hotel Policies') }}</h6>
                            <ul class="text-muted small ps-3 mb-3">
                                <li>No smoking in rooms</li>
                                <li>Pets are not allowed</li>
                                <li>Quiet hours: 10:00 PM - 7:00 AM</li>
                            </ul>
                            
                            <h6 class="fw-bold mb-2">{{ __('Contact') }}</h6>
                            <p class="text-muted small mb-0">For any questions, please contact us at <a href="mailto:support@gincehotel.com" class="text-secondary">support@gincehotel.com</a> or call +1 (123) 456-7890.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection