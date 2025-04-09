<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Str;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's bookings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()->orderBy('created_at', 'desc')->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        return view('bookings.show', compact('booking'));
    }

    public function pay(Request $request, Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->status === 'pending_payment', 400);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Create payment charge
            $payment = \Stripe\Charge::create([
                'amount' => $booking->total_price * 100,
                'currency' => 'usd',
                'source' => $request->payment_method_id,
                'description' => 'Booking #' . $booking->id,
                'metadata' => [
                    'booking_id' => $booking->id,
                    'user_id' => Auth::id()
                ],
            ]);

            $booking->update([
                'status' => 'confirmed',
                'payment_id' => $payment->id,
                'payment_date' => now(),
            ]);

            return redirect()->route('bookings.index')->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            return back()->withErrors(['payment' => $e->getMessage()]);
        }
    }
    
    public function create(Room $room)
    {
        return view('bookings.create', compact('room'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in|max:30', 
        ]);

        $room = Room::findOrFail($validated['room_id']);

        $conflictingBookings = Booking::where('room_id', $room->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('check_in', [$validated['check_in'], $validated['check_out']])
                    ->orWhereBetween('check_out', [$validated['check_in'], $validated['check_out']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('check_in', '<', $validated['check_in'])
                                ->where('check_out', '>', $validated['check_out']);
                    });
            })->exists();

        if ($conflictingBookings) {
            return back()->withErrors(['dates' => 'This room is not available for the selected dates'])->withInput();
        }

        // Calculate total price using Carbon for accurate day difference
        $checkIn = \Carbon\Carbon::parse($validated['check_in']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out']);
        $days = $checkOut->diffInDays($checkIn);
        $totalPrice = $room->price * $days;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'total_price' => $totalPrice,
            'status' => 'pending_payment',
        ]);

        return redirect()->route('bookings.show', $booking);
    }
}