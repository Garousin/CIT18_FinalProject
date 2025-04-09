@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Booking #{{ $booking->id }}</h1>
        <a href="{{ route('admin.bookings.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Bookings
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Booking Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group row mb-3">
                    <div class="col-md-6">
                        <label for="user_id">Guest</label>
                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">Select Guest</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ (old('user_id') ?? $booking->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="room_id">Room</label>
                        <select name="room_id" id="room_id" class="form-control @error('room_id') is-invalid @enderror">
                            <option value="">Select Room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ (old('room_id') ?? $booking->room_id) == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }} - ${{ number_format($room->price, 2) }}/night
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row mb-3">
                    <div class="col-md-6">
                        <label for="check_in">Check In Date</label>
                        <input type="date" name="check_in" id="check_in" class="form-control @error('check_in') is-invalid @enderror" value="{{ old('check_in') ?? $booking->check_in }}">
                        @error('check_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="check_out">Check Out Date</label>
                        <input type="date" name="check_out" id="check_out" class="form-control @error('check_out') is-invalid @enderror" value="{{ old('check_out') ?? $booking->check_out }}">
                        @error('check_out')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row mb-3">
                    <div class="col-md-6">
                        <label for="total_price">Total Price</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" name="total_price" id="total_price" class="form-control @error('total_price') is-invalid @enderror" value="{{ old('total_price') ?? $booking->total_price }}" step="0.01" min="0">
                        </div>
                        @error('total_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="pending" {{ (old('status') ?? $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ (old('status') ?? $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ (old('status') ?? $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ (old('status') ?? $booking->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.getElementById('room_id');
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const totalPriceInput = document.getElementById('total_price');
        
        function calculateTotalPrice() {
            const roomId = roomSelect.value;
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            
            if (!roomId || !checkInInput.value || !checkOutInput.value) {
                return;
            }
            
            if (checkOut <= checkIn) {
                return;
            }
            
            const diffTime = Math.abs(checkOut - checkIn);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            const priceText = selectedOption.text.match(/\$([0-9]+(\.[0-9]+)?)/);
            
            if (priceText && priceText[1]) {
                const pricePerNight = parseFloat(priceText[1]);
                const totalPrice = pricePerNight * diffDays;
                totalPriceInput.value = totalPrice.toFixed(2);
            }
        }
        
        roomSelect.addEventListener('change', calculateTotalPrice);
        checkInInput.addEventListener('change', calculateTotalPrice);
        checkOutInput.addEventListener('change', calculateTotalPrice);
    });
</script>
@endsection 