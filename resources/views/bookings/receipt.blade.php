@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <h2 class="fs-4 m-0">Payment Successful</h2>
                    <div class="ms-auto">
                        <button class="btn btn-sm btn-outline-light" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> Print Receipt
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-check-circle text-success fs-1"></i>
                        </div>
                        <h3 class="fs-4 fw-bold">Thank You for Your Booking!</h3>
                        <p class="text-muted">Your payment has been processed successfully.</p>
                    </div>

                    <div class="receipt-details">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h4 class="fs-5 fw-bold mb-3">Receipt Details</h4>
                                <p><strong>Receipt #:</strong> R-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                                <p><strong>Date:</strong> {{ $booking->payment_date->format('M d, Y, h:i A') }}</p>
                                <p>
                                    <strong>Payment Method:</strong> 
                                    @if($booking->payment_method === 'credit_card')
                                        <span>
                                            <i class="fas fa-credit-card me-1"></i>
                                            Credit Card
                                        </span>
                                    @elseif($booking->payment_method === 'paypal')
                                        <span>
                                            <i class="fab fa-paypal me-1"></i>
                                            PayPal
                                        </span>
                                    @else
                                        <span>Online Payment</span>
                                    @endif
                                </p>
                                <p><strong>Payment ID:</strong> {{ $booking->payment_id }}</p>
                            </div>
                            <div class="col-md-6">
                                <h4 class="fs-5 fw-bold mb-3">Guest Information</h4>
                                <p><strong>Name:</strong> {{ $booking->user->name }}</p>
                                <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                                <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
                                <p><strong>Booking Status:</strong> <span class="badge bg-success">Confirmed</span></p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h4 class="fs-5 fw-bold mb-3">Booking Details</h4>
                        <div class="row mb-4 align-items-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <img src="{{ $booking->room->image ?? 'https://via.placeholder.com/600x400' }}" 
                                     class="img-fluid rounded" alt="{{ $booking->room->name }}">
                            </div>
                            <div class="col-md-8">
                                <h5 class="fw-bold">{{ $booking->room->name }}</h5>
                                <div class="d-flex flex-wrap mb-2">
                                    <span class="me-3 mb-2"><i class="fas fa-calendar-check text-success me-1"></i> {{ $booking->check_in->format('M d, Y') }}</span>
                                    <span class="me-3 mb-2"><i class="fas fa-calendar-minus text-danger me-1"></i> {{ $booking->check_out->format('M d, Y') }}</span>
                                    <span class="mb-2"><i class="fas fa-moon me-1"></i> {{ $booking->check_in->diffInDays($booking->check_out) }} night(s)</span>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">Payment Summary</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Room Rate:</span>
                                    <span>${{ number_format($booking->room->price, 2) }} / night</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Duration:</span>
                                    <span>{{ $booking->check_in->diffInDays($booking->check_out) }} night(s)</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($booking->total_price, 2) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total:</span>
                                    <span class="fs-5 text-success">${{ number_format($booking->total_price, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="additional-info">
                            <h5 class="fw-bold mb-3">Additional Information</h5>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="fas fa-info-circle text-primary fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Check-in Instructions</h6>
                                            <p class="mb-0">Check-in time starts at 2:00 PM. Please present this receipt and a valid ID at the front desk.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="fas fa-phone-alt text-primary fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Need Help?</h6>
                                            <p class="mb-0">If you have any questions, please contact our support team at <a href="mailto:support@hotel.com">support@hotel.com</a> or call +1-800-123-4567.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('bookings.index') }}" class="btn btn-primary">
                                <i class="fas fa-list-alt me-2"></i>View All Bookings
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                <i class="fas fa-home me-2"></i>Return to Homepage
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0 small text-muted">This is an electronic receipt of your payment. Please keep it for your records.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style media="print">
    @page {
        size: auto;
        margin: 0mm;
    }
    body {
        padding: 20px;
    }
    button.btn, .d-grid {
        display: none !important;
    }
    .card {
        box-shadow: none !important;
        border: 1px solid #dee2e6;
    }
    .text-white {
        color: #000 !important;
    }
    .bg-success, .bg-primary, .bg-light {
        background-color: transparent !important;
    }
</style>
@endsection 