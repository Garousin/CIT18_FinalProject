@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Booking #{{ $booking->id }}</h1>
        <div>
            @if($booking->status == 'confirmed')
            <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" class="d-inline">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success btn-sm shadow-sm" onclick="return confirm('Mark this booking as completed and proceed to payment?')">
                    <i class="fas fa-check fa-sm text-white-50"></i> Complete & Proceed to Payment
                </button>
            </form>
            @endif
            
            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-primary btn-sm shadow-sm ml-2">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Booking
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Bookings
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Booking Status Timeline -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Booking Timeline</h6>
        </div>
        <div class="card-body">
            <div class="timeline-steps">
                <div class="timeline-step {{ in_array($booking->status, ['pending', 'confirmed', 'completed']) ? 'active' : '' }}">
                    <div class="timeline-content">
                        <div class="inner-circle {{ in_array($booking->status, ['pending', 'confirmed', 'completed']) ? 'bg-primary' : 'bg-secondary' }}">
                            <i class="fas fa-clipboard"></i>
                        </div>
                        <p class="h6 mt-3 mb-1">Created</p>
                        <p class="h6 text-muted mb-0 mb-lg-0">{{ $booking->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="timeline-step {{ in_array($booking->status, ['confirmed', 'completed']) ? 'active' : '' }}">
                    <div class="timeline-content">
                        <div class="inner-circle {{ in_array($booking->status, ['confirmed', 'completed']) ? 'bg-primary' : 'bg-secondary' }}">
                            <i class="fas fa-check"></i>
                        </div>
                        <p class="h6 mt-3 mb-1">Confirmed</p>
                        <p class="h6 text-muted mb-0 mb-lg-0">{{ $booking->status == 'pending' ? 'Pending' : ($booking->updated_at ? $booking->updated_at->format('M d, Y') : '-') }}</p>
                    </div>
                </div>
                <div class="timeline-step {{ $booking->status == 'completed' ? 'active' : '' }}">
                    <div class="timeline-content">
                        <div class="inner-circle {{ $booking->status == 'completed' ? 'bg-primary' : 'bg-secondary' }}">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <p class="h6 mt-3 mb-1">Completed</p>
                        <p class="h6 text-muted mb-0 mb-lg-0">{{ $booking->status == 'completed' ? $booking->updated_at->format('M d, Y') : 'Not Completed' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Booking Information</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Booking Actions:</div>
                            <a class="dropdown-item" href="{{ route('admin.bookings.edit', $booking) }}"><i class="fas fa-edit fa-sm fa-fw text-gray-400"></i> Edit Booking</a>
                            <a class="dropdown-item" href="#" onclick="window.print()"><i class="fas fa-print fa-sm fa-fw text-gray-400"></i> Print Details</a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this booking? This action cannot be undone.')">
                                    <i class="fas fa-trash fa-sm fa-fw text-danger"></i> Delete Booking
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Status</div>
                                            <div class="h5 mb-0 font-weight-bold">
                                                <span class="badge badge-{{ 
                                                    $booking->status == 'confirmed' ? 'success' : 
                                                    ($booking->status == 'pending' ? 'warning' : 
                                                    ($booking->status == 'completed' ? 'info' : 'danger')) 
                                                }} p-2">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Price</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($booking->total_price, 2) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%" class="bg-light">Booking ID</th>
                                    <td>{{ $booking->id }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Check In</th>
                                    <td>
                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }}
                                        @if(\Carbon\Carbon::parse($booking->check_in)->isToday())
                                            <span class="badge badge-success ml-2">Today</span>
                                        @elseif(\Carbon\Carbon::parse($booking->check_in)->isPast())
                                            <span class="badge badge-info ml-2">Past</span>
                                        @else
                                            <span class="badge badge-primary ml-2">Upcoming</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Check Out</th>
                                    <td>
                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}
                                        @if(\Carbon\Carbon::parse($booking->check_out)->isToday())
                                            <span class="badge badge-success ml-2">Today</span>
                                        @elseif(\Carbon\Carbon::parse($booking->check_out)->isPast())
                                            <span class="badge badge-info ml-2">Past</span>
                                        @else
                                            <span class="badge badge-primary ml-2">Upcoming</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Length of Stay</th>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->diffInDays(\Carbon\Carbon::parse($booking->check_in)) }} nights</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Price Per Night</th>
                                    <td>${{ number_format($booking->room->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Total Price</th>
                                    <td>${{ number_format($booking->total_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Payment Status</th>
                                    <td>
                                        @if($booking->payment_id)
                                            <span class="badge badge-success">Paid</span>
                                            <span class="ml-2">{{ $booking->payment_method }}: {{ $booking->payment_id }}</span>
                                        @else
                                            <span class="badge badge-warning">Not Paid</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Created On</th>
                                    <td>{{ $booking->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Last Updated</th>
                                    <td>{{ $booking->updated_at->format('F d, Y h:i A') }} ({{ $booking->updated_at->diffForHumans() }})</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Notes Section -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Admin Notes</h6>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Add notes about this booking..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Save Note</button>
                    </form>
                    
                    <hr>
                    
                    <div class="timeline mt-3">
                        <!-- Example note, would be populated from database -->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">Today</div>
                                <div class="timeline-item-marker-indicator bg-primary"></div>
                            </div>
                            <div class="timeline-item-content">
                                <p class="mb-0">System note: Booking marked as completed</p>
                                <small class="text-muted">Admin User, 12:47 PM</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Guest Information</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode($booking->user->name) }}&size=128" width="100">
                        <h5 class="mt-3">{{ $booking->user->name }}</h5>
                        <p class="text-muted">
                            <i class="fas fa-envelope mr-1"></i> {{ $booking->user->email }}
                        </p>
                    </div>
                    
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="40%" class="bg-light">User ID</th>
                                    <td>{{ $booking->user->id }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Total Bookings</th>
                                    <td>{{ $booking->user->bookings()->count() }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Member Since</th>
                                    <td>{{ $booking->user->created_at->format('F d, Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.users.show', $booking->user->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-user mr-1"></i> View Guest Profile
                        </a>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Room Information</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($booking->room->image)
                            <img class="img-fluid mb-3 rounded" src="{{ asset('storage/'.$booking->room->image) }}" alt="{{ $booking->room->name }}">
                        @else
                            <div class="bg-light p-4 mb-3 rounded">
                                <i class="fas fa-bed fa-3x text-gray-400"></i>
                                <p class="mt-2 text-gray-500">No image available</p>
                            </div>
                        @endif
                        <h5>{{ $booking->room->name }}</h5>
                        <p class="text-primary font-weight-bold">${{ number_format($booking->room->price, 2) }} / night</p>
                    </div>
                    
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="40%" class="bg-light">Room ID</th>
                                    <td>{{ $booking->room->id }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Capacity</th>
                                    <td>{{ $booking->room->capacity }} people</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Current Status</th>
                                    <td>
                                        @php
                                            $isOccupied = App\Models\Booking::where('room_id', $booking->room_id)
                                                ->where('status', 'confirmed')
                                                ->where('check_in', '<=', date('Y-m-d'))
                                                ->where('check_out', '>=', date('Y-m-d'))
                                                ->exists();
                                        @endphp
                                        
                                        @if($isOccupied)
                                            <span class="badge badge-danger">Occupied</span>
                                        @else
                                            <span class="badge badge-success">Available</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.rooms.show', $booking->room->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-door-open mr-1"></i> View Room Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-steps {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

.timeline-step {
    align-items: center;
    display: flex;
    flex-direction: column;
    position: relative;
    margin: 1rem;
    flex: 1;
}

.timeline-step:not(:last-child):after {
    content: "";
    display: block;
    border-top: .25rem dotted #e5e5e5;
    width: 100%;
    position: absolute;
    right: -50%;
    top: 1rem;
    z-index: -1;
}

.timeline-step.active:not(:last-child):after {
    border-top: .25rem dotted #3a72eb;
}

.timeline-step .inner-circle {
    width: 60px;
    height: 60px;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.timeline-step .inner-circle i {
    font-size: 1.5rem;
}

.timeline-item {
    display: flex;
    margin-bottom: 1rem;
}

.timeline-item-marker {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-right: 1rem;
}

.timeline-item-marker-text {
    font-size: 0.75rem;
    color: #a2acba;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.timeline-item-marker-indicator {
    height: 1.5rem;
    width: 1.5rem;
    border-radius: 100%;
}

.timeline-item-content {
    padding-top: 0.25rem;
    flex-grow: 1;
}
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-refresh the page for real-time updates
        setInterval(function() {
            $.get(window.location.href, function(response) {
                var newStatusBadge = $(response).find('.badge:contains("' + $('.badge:contains("Pending"), .badge:contains("Confirmed"), .badge:contains("Completed"), .badge:contains("Cancelled")").text() + '")').parent().html();
                $('.badge:contains("Pending"), .badge:contains("Confirmed"), .badge:contains("Completed"), .badge:contains("Cancelled")').parent().html(newStatusBadge);
                
                // Update timeline
                var newTimeline = $(response).find('.timeline-steps').html();
                $('.timeline-steps').html(newTimeline);
            });
        }, 30000); // Refresh every 30 seconds
    });
</script>
@endpush
@endsection 