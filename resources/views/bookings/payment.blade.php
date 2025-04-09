@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="fs-4 m-0">Payment for Booking #{{ $booking->id }}</h2>
                </div>
                <div class="card-body">
                    <div class="booking-details mb-4">
                        <h3 class="fs-5 fw-bold mb-3">Booking Details</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Room:</strong> {{ $booking->room->name }}</p>
                                <p><strong>Check-in:</strong> {{ date('M d, Y', strtotime($booking->check_in)) }}</p>
                                <p><strong>Check-out:</strong> {{ date('M d, Y', strtotime($booking->check_out)) }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} nights</p>
                                <p><strong>Amount:</strong> ${{ number_format($booking->total_price, 2) }}</p>
                                <p><strong>Status:</strong> <span class="badge bg-warning">Awaiting Payment</span></p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h3 class="fs-5 fw-bold mb-3">Payment Method</h3>
                    
                    <div class="payment-methods mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check payment-method-card border p-3 rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                                    <label class="form-check-label w-100" for="credit_card">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="fw-bold mb-1">Credit/Debit Card</div>
                                                <div class="small text-muted">Visa, Mastercard, Amex, Discover</div>
                                            </div>
                                            <div class="payment-icons">
                                                <i class="fab fa-cc-visa text-primary"></i>
                                                <i class="fab fa-cc-mastercard text-danger"></i>
                                                <i class="fab fa-cc-amex text-info"></i>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check payment-method-card border p-3 rounded">
                                    <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                    <label class="form-check-label w-100" for="paypal">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="fw-bold mb-1">PayPal</div>
                                                <div class="small text-muted">Pay with your PayPal account</div>
                                            </div>
                                            <div>
                                                <i class="fab fa-paypal fa-lg text-primary"></i>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="credit-card-payment" class="payment-form">
                        <form action="{{ route('bookings.pay', $booking) }}" method="POST" id="payment-form">
                            @csrf
                            <input type="hidden" name="payment_type" value="credit_card">
                            @if(session('error') || $errors->any())
                                <div class="alert alert-danger">
                                    {{ session('error') ?? $errors->first() }}
                                </div>
                            @endif

                            <div id="card-element" class="form-control mb-3">
                                <!-- Stripe Element will be inserted here -->
                            </div>
                            <div id="card-errors" class="text-danger mb-3" role="alert"></div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" id="submit-button">
                                    <i class="fas fa-lock me-2"></i>Pay ${{ number_format($booking->total_price, 2) }}
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div id="paypal-payment" class="payment-form d-none">
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            You'll be redirected to PayPal to complete your payment.
                        </div>
                        <form action="{{ route('bookings.pay', $booking) }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_type" value="paypal">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fab fa-paypal me-2"></i>Pay with PayPal
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="text-center mt-4">
                        <p class="small text-muted mb-1">Secure Payment Processed by Stripe</p>
                        <div class="payment-icons">
                            <i class="fab fa-cc-visa mx-1 text-secondary fs-4"></i>
                            <i class="fab fa-cc-mastercard mx-1 text-secondary fs-4"></i>
                            <i class="fab fa-cc-amex mx-1 text-secondary fs-4"></i>
                            <i class="fab fa-cc-discover mx-1 text-secondary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method selection
        const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
        const creditCardForm = document.getElementById('credit-card-payment');
        const paypalForm = document.getElementById('paypal-payment');
        
        paymentMethodRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'credit_card') {
                    creditCardForm.classList.remove('d-none');
                    paypalForm.classList.add('d-none');
                } else if (this.value === 'paypal') {
                    paypalForm.classList.remove('d-none');
                    creditCardForm.classList.add('d-none');
                }
            });
        });
        
        // Add active class to selected payment method
        const paymentMethodCards = document.querySelectorAll('.payment-method-card');
        paymentMethodCards.forEach(card => {
            card.addEventListener('click', function() {
                paymentMethodCards.forEach(c => c.classList.remove('border-primary'));
                this.classList.add('border-primary');
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            });
        });
        
        // Initialize the credit card selection
        document.getElementById('credit_card').checked = true;
        document.querySelector('label[for="credit_card"]').closest('.payment-method-card').classList.add('border-primary');
        
        // Initialize Stripe
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        
        // Create card Element and mount it
        const cardElement = elements.create('card', {
            style: {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
        });
        cardElement.mount('#card-element');
        
        // Handle form submission
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const cardErrors = document.getElementById('card-errors');
        
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            
            // Disable the submit button to prevent repeated clicks
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            
            try {
                const { paymentMethod, error } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardElement
                });
                
                if (error) {
                    // Show error and re-enable button
                    cardErrors.textContent = error.message;
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pay ${{ number_format($booking->total_price, 2) }}';
                } else {
                    // If no errors, append payment method ID to form and submit
                    const hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'payment_method_id');
                    hiddenInput.setAttribute('value', paymentMethod.id);
                    form.appendChild(hiddenInput);
                    
                    form.submit();
                }
            } catch (e) {
                cardErrors.textContent = "An unexpected error occurred. Please try again.";
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-lock me-2"></i>Pay ${{ number_format($booking->total_price, 2) }}';
            }
        });
    });
</script>
@endpush
@endsection 