@extends('admin.layouts.app')

@section('title', 'Manage Rooms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fs-2 fw-bold">Manage Rooms</h1>
        <div>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Room
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-bed me-2 text-primary"></i>
            All Rooms
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Capacity</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $room)
                            <tr>
                                <td>#{{ $room->id }}</td>
                                <td>
                                    <img src="{{ $room->image ?? 'https://via.placeholder.com/100x60' }}" 
                                         alt="{{ $room->name }}" 
                                         class="img-thumbnail" 
                                         style="width: 100px; height: 60px; object-fit: cover;">
                                </td>
                                <td>{{ $room->name }}</td>
                                <td>{{ Str::limit($room->description, 50) }}</td>
                                <td>{{ $room->capacity ?? 2 }} Guest(s)</td>
                                <td>${{ number_format($room->price, 2) }}/night</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-3">
                                    <p class="text-muted mb-0">No rooms available</p>
                                    <a href="{{ route('admin.rooms.create') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="fas fa-plus me-2"></i>Add Room
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $rooms->links() }}
    </div>
</div>
@endsection 