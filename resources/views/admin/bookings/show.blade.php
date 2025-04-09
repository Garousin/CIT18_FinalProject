@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Booking #{{ $booking->id }}</h1>
        <div>
            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Booking
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Bookings
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Booking Information</h6>
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
                                                }}">
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
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Check Out</th>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Length of Stay</th>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->diffInDays(\Carbon\Carbon::parse($booking->check_in)) }} nights</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Created On</th>
                                    <td>{{ $booking->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Last Updated</th>
                                    <td>{{ $booking->updated_at->format('F d, Y h:i A') }}</td>
                                </tr>
                            </tbody>
                        </table>
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
                    
                    <div class="text-center">
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
                            <img class="img-fluid mb-3" src="{{ asset('storage/'.$booking->room->image) }}" alt="{{ $booking->room->name }}">
                        @else
                            <div class="bg-light p-4 mb-3">
                                <i class="fas fa-bed fa-3x text-gray-400"></i>
                                <p class="mt-2 text-gray-500">No image available</p>
                            </div>
                        @endif
                        <h5>{{ $booking->room->name }}</h5>
                        <p class="text-primary font-weight-bold">${{ number_format($booking->room->price, 2) }} / night</p>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ route('admin.rooms.show', $booking->room->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-door-open mr-1"></i> View Room Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 