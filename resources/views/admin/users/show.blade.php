@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Details</h1>
        <div>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128" width="100">
                        <h5 class="mt-3">{{ $user->name }}</h5>
                        <span class="badge {{ $user->is_admin ? 'badge-primary' : 'badge-secondary' }}">
                            {{ $user->is_admin ? 'Admin' : 'User' }}
                        </span>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%" class="bg-light">ID</th>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Created</th>
                                    <td>{{ $user->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Last Updated</th>
                                    <td>{{ $user->updated_at->format('F d, Y h:i A') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Bookings</h6>
                </div>
                <div class="card-body">
                    @if(count($bookings) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Room</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->room->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</td>
                                    <td>${{ number_format($booking->total_price, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $booking->status == 'confirmed' ? 'success' : 
                                            ($booking->status == 'pending' ? 'warning' : 
                                            ($booking->status == 'completed' ? 'info' : 'danger')) 
                                        }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">This user has no bookings yet.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 