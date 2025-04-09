@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Bookings</h1>
        <a href="{{ route('admin.bookings.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Booking
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter and Booking Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Bookings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Booking::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Confirmed Bookings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Booking::where('status', 'confirmed')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Completed Bookings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Booking::where('status', 'completed')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Bookings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Booking::where('status', 'pending')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Controls -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Bookings</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="form-inline">
                <div class="form-group mb-2 mr-2">
                    <label for="status" class="sr-only">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="form-group mb-2 mr-2">
                    <label for="from_date" class="sr-only">From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" value="{{ request('from_date') }}">
                </div>
                <div class="form-group mb-2 mr-2">
                    <label for="to_date" class="sr-only">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" value="{{ request('to_date') }}">
                </div>
                <button type="submit" class="btn btn-primary mb-2 mr-2">Filter</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary mb-2">Reset</a>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">All Bookings</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Export Options:</div>
                    <a class="dropdown-item" href="#">Export to CSV</a>
                    <a class="dropdown-item" href="#">Export to PDF</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr class="{{ $booking->check_in->isPast() && $booking->check_out->isFuture() && $booking->status == 'confirmed' ? 'table-primary' : '' }}">
                            <td>{{ $booking->id }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $booking->user_id) }}" class="font-weight-bold text-primary">
                                    {{ $booking->user->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.rooms.show', $booking->room_id) }}">
                                    {{ $booking->room->name }}
                                </a>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out) }} nights</td>
                            <td>${{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ 
                                    $booking->status == 'confirmed' ? 'success' : 
                                    ($booking->status == 'pending' ? 'warning' : 
                                    ($booking->status == 'completed' ? 'info' : 'danger')) 
                                }} p-2">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>{{ $booking->created_at->diffForHumans() }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-info btn-sm" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-primary btn-sm" title="Edit Booking">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($booking->status == 'confirmed')
                                    <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm" title="Mark as Completed" onclick="return confirm('Mark this booking as completed and proceed to payment?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Booking" onclick="return confirm('Are you sure you want to delete this booking? This action cannot be undone.')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable({
            "order": [[0, "desc"]],
            "pageLength": 25,
            "searching": true,
            "paging": false, // Disable DataTables paging as we're using Laravel pagination
            "info": false
        });
        
        // Tooltip initialization
        $('[title]').tooltip();
        
        // Auto-update page
        setInterval(function() {
            $.get(window.location.href, function(response) {
                // Extract the table body content from the response
                var newTableBody = $(response).find('#dataTable tbody').html();
                $('#dataTable tbody').html(newTableBody);
                
                // Update the stats cards as well
                $(response).find('.card.border-left-primary .h5').each(function(index) {
                    $('.card.border-left-primary .h5').eq(index).text($(this).text());
                });
                
                $(response).find('.card.border-left-success .h5').each(function(index) {
                    $('.card.border-left-success .h5').eq(index).text($(this).text());
                });
                
                $(response).find('.card.border-left-info .h5').each(function(index) {
                    $('.card.border-left-info .h5').eq(index).text($(this).text());
                });
                
                $(response).find('.card.border-left-warning .h5').each(function(index) {
                    $('.card.border-left-warning .h5').eq(index).text($(this).text());
                });
            });
        }, 60000); // Update every minute
    });
</script>
@endpush
@endsection 