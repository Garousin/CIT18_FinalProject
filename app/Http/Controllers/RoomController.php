<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->format('Y-m-d');
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        
        $checkIn = $request->input('check_in', $today);
        $checkOut = $request->input('check_out', $tomorrow);

        // Get IDs of rooms that are booked during the selected date range
        $bookedRoomIds = Booking::where(function($query) use ($checkIn, $checkOut) {
            $query->where(function($q) use ($checkIn, $checkOut) {
                // Check if the booking check-in date is between the selected dates
                $q->whereBetween('check_in', [$checkIn, $checkOut]);
            })->orWhere(function($q) use ($checkIn, $checkOut) {
                // Check if the booking check-out date is between the selected dates
                $q->whereBetween('check_out', [$checkIn, $checkOut]);
            })->orWhere(function($q) use ($checkIn, $checkOut) {
                // Check if the booking surrounds the selected dates
                $q->where('check_in', '<=', $checkIn)
                  ->where('check_out', '>=', $checkOut);
            });
        })
        ->where('status', 'confirmed') // Only consider confirmed bookings
        ->pluck('room_id')
        ->toArray();
        
        // Get all available rooms (not in the booked room IDs)
        $rooms = Room::whereNotIn('id', $bookedRoomIds)->get();
        
        return view('home', compact('rooms', 'checkIn', 'checkOut'));
    }
}
