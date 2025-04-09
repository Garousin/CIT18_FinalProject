@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fs-2 fw-bold">
            <i class="fas fa-calendar-check me-2 text-secondary"></i>{{ __('My Bookings') }}
        </h1>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="fas fa-plus me-2"></i>{{ __('Book Another Room') }}
        </a>
    </div>

    @if($bookings->isEmpty())
        <div class="card shadow border-0">
            <div class="card-body text-center py-5">
                <div class="py-3">
                    <i class="fas fa-calendar-day fa-4x text-secondary mb-4"></i>
                    <h3 class="fs-4 fw-semibold">{{ __('No Bookings Yet') }}</h3>
                    <p class="text-muted mb-4">{{ __('You haven\'t made any bookings yet. Start by booking a room!') }}</p>
                    <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-hotel me-2"></i>{{ __('Browse Rooms') }}
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">{{ __('Room') }}</th>
                                        <th class="py-3">{{ __('Dates') }}</th>
                                        <th class="py-3">{{ __('Total') }}</th>
                                        <th class="py-3">{{ __('Status') }}</th>
                                        <th class="pe-4 py-3 text-end">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img class="rounded" width="70" height="70"
                                                         src="{{ $booking->room->image ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80' }}" 
                                                         alt="{{ $booking->room->name }}"
                                                         style="object-fit: cover;">
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="fw-bold mb-0">{{ $booking->room->name }}</h6>
                                                    <small class="text-muted">{{ $booking->room->capacity }} {{ __('Guest(s)') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="mb-1">
                                                    <i class="fas fa-sign-in-alt text-success me-1"></i>
                                                    <span>{{ $booking->check_in->format('M d, Y') }}</span>
                                                </div>
                                                <div>
                                                    <i class="fas fa-sign-out-alt text-danger me-1"></i>
                                                    <span>{{ $booking->check_out->format('M d, Y') }}</span>
                                                </div>
                                                <small class="text-muted">
                                                    {{ $booking->check_in->diffInDays($booking->check_out) }} {{ __('night(s)') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">${{ number_format($booking->total_price, 2) }}</span>
                                        </td>
                                        <td>
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
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye me-1"></i>{{ __('View') }}
                                            </a>
                                            @if($booking->status === 'pending_payment')
                                                <a href="{{ route('bookings.payment', $booking) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-credit-card me-1"></i>{{ __('Pay Now') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            {{ $bookings->links() }}
        </div>
        
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-question-circle text-secondary fs-4 me-3"></i>
                            <h5 class="fw-bold mb-0">{{ __('Need Help?') }}</h5>
                        </div>
                        <p class="text-muted mb-0">If you have any questions about your booking, please contact our customer service team at <a href="mailto:support@gincehotel.com" class="text-secondary">support@gincehotel.com</a> or call us at +1 (123) 456-7890.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-info-circle text-secondary fs-4 me-3"></i>
                            <h5 class="fw-bold mb-0">{{ __('Booking Information') }}</h5>
                        </div>
                        <ul class="text-muted mb-0 ps-0" style="list-style-type: none;">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Check-in time starts at 2:00 PM</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Check-out time is 11:00 AM</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Free cancellation up to 24 hours before check-in</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection