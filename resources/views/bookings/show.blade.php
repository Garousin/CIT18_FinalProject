@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="mb-4">
            <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Bookings') }}
            </a>
        </div>
        
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <i class="fas fa-receipt me-2 text-primary"></i>
                <span class="fs-5 fw-semibold">{{ __('Booking Details') }}</span>
                <div class="ms-auto">
                    @if($booking->status === 'confirmed')
                        <span class="badge bg-success rounded-pill px-3 py-2">
                            <i class="fas fa-check-circle me-1"></i>{{ __('Confirmed') }}
                        </span>
                    @elseif($booking->status === 'pending')
                        <span class="badge bg-warning rounded-pill px-3 py-2">
                            <i class="fas fa-clock me-1"></i>{{ __('Pending') }}
                        </span>
                    @elseif($booking->status === 'cancelled')
                        <span class="badge bg-danger rounded-pill px-3 py-2">
                            <i class="fas fa-times-circle me-1"></i>{{ __('Cancelled') }}
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-5 mb-4 mb-md-0">
                        <img src="{{ $booking->room->image ?? 'https://via.placeholder.com/600x400' }}" 
                             alt="{{ $booking->room->name }}" 
                             class="img-fluid rounded mb-3">
                             
                        <h3 class="fs-5 fw-semibold">{{ $booking->room->name }}</h3>
                        <p class="text-muted">{{ Str::limit($booking->room->description, 150) }}</p>
                        
                        <div class="d-flex mb-3">
                            <div class="me-4" title="Max occupancy"><i class="fas fa-user me-1"></i> {{ $booking->room->capacity ?? 2 }} Guests</div>
                            <div title="Free WiFi"><i class="fas fa-wifi me-1"></i> Free WiFi</div>
                        </div>
                    </div>
                    
                    <div class="col-md-7">
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h4 class="card-title fs-5 fw-semibold mb-3">{{ __('Reservation Information') }}</h4>
                                
                                <div class="row mb-2">
                                    <div class="col-md-6 mb-3">
                                        <div class="mb-3">
                                            <span class="d-block text-muted small">{{ __('Booking ID') }}</span>
                                            <span class="fw-medium">#{{ $booking->id }}</span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <span class="d-block text-muted small">{{ __('Booking Date') }}</span>
                                            <span class="fw-medium">{{ $booking->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="mb-3">
                                            <span class="d-block text-muted small">{{ __('Guest Name') }}</span>
                                            <span class="fw-medium">{{ $booking->user->name }}</span>
                                        </div>
                                        
                                        <div>
                                            <span class="d-block text-muted small">{{ __('Email') }}</span>
                                            <span class="fw-medium">{{ $booking->user->email }}</span>
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
                                                <span class="fw-medium">{{ $booking->check_in->format('D, M d, Y') }}</span>
                                            </div>
                                            <small class="text-muted">{{ __('After 2:00 PM') }}</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div>
                                            <span class="d-block text-muted small">{{ __('Check-out') }}</span>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-calendar-minus text-danger me-2"></i>
                                                <span class="fw-medium">{{ $booking->check_out->format('D, M d, Y') }}</span>
                                            </div>
                                            <small class="text-muted">{{ __('Before 11:00 AM') }}</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <span class="d-block text-muted small">{{ __('Duration') }}</span>
                                    <span class="fw-medium">{{ $booking->check_in->diffInDays($booking->check_out) }} {{ __('night(s)') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card bg-white mb-4">
                            <div class="card-body">
                                <h4 class="card-title fs-5 fw-semibold mb-3">{{ __('Payment Summary') }}</h4>
                                
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
                                    <span>{{ __('Total Paid') }}:</span>
                                    <span class="fs-5 text-primary">${{ number_format($booking->total_price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        @if($booking->status === 'pending_payment')
                        <form action="{{ route('bookings.pay', $booking) }}" method="POST" id="payment-form">
                            @csrf
                            <div class="mb-4">
                                <label for="card-element" class="form-label fw-medium">
                                    {{ __('Credit or debit card') }}
                                </label>
                                <div id="card-element" class="form-control p-3" style="height: 100px;"></div>
                                <div id="card-errors" class="text-danger mt-2 small"></div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-3" id="submit-button">
                                    <i class="fas fa-credit-card me-2"></i>{{ __('Pay Now') }}
                                </button>
                            </div>
                        </form>
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
    </div>
</div>

@if($booking->status === 'pending_payment')
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        
        const style = {
            base: {
                color: '#32325d',
                fontFamily: '"Poppins", sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#dc3545',
                iconColor: '#dc3545'
            }
        };
        
        const cardElement = elements.create('card', { style: style });
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const displayError = document.getElementById('card-errors');

        cardElement.addEventListener('change', function(event) {
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';

            const {error, paymentMethod} = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            });

            if (error) {
                displayError.textContent = error.message;
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-credit-card me-2"></i>{{ __('Pay Now') }}';
            } else {
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method_id');
                hiddenInput.setAttribute('value', paymentMethod.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });
    });
</script>
@endif
@endsection