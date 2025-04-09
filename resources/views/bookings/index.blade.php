@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fs-2 fw-bold mb-0">
            <i class="fas fa-calendar-check me-2 text-primary"></i>{{ __('My Bookings') }}
        </h1>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="fas fa-plus me-2"></i>{{ __('Book Another Room') }}
        </a>
    </div>

    @if($bookings->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-day fa-4x text-muted mb-4"></i>
                <h3 class="fs-4 fw-semibold">{{ __('No Bookings Yet') }}</h3>
                <p class="text-muted mb-4">{{ __('You haven\'t made any bookings yet. Start by booking a room!') }}</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-hotel me-2"></i>{{ __('Browse Rooms') }}
                </a>
            </div>
        </div>
    @else
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
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
                                                    <img class="rounded" width="60" height="60"
                                                         src="{{ $booking->room->image ?? 'https://via.placeholder.com/100' }}" 
                                                         alt="{{ $booking->room->name }}"
                                                         style="object-fit: cover;">
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-0 fw-semibold">{{ $booking->room->name }}</h6>
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
                                            <span class="fw-semibold">${{ number_format($booking->total_price, 2) }}</span>
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
    @endif
</div>
@endsection