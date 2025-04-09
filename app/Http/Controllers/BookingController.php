<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Str;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    /**
     * Show the payment page for a booking
     *
     * @param \App\Models\Booking $booking
     * @return \Illuminate\View\View
     */
    public function showPayment(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->status === 'pending_payment', 400, 'This booking does not require payment.');
        
        return view('bookings.payment', compact('booking'));
    }

    public function pay(Request $request, Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->status === 'pending_payment', 400);

        $paymentType = $request->input('payment_type', 'credit_card');
        
        if ($paymentType === 'credit_card') {
            return $this->processCardPayment($request, $booking);
        } elseif ($paymentType === 'paypal') {
            return $this->processPayPalPayment($request, $booking);
        }
        
        return back()->withErrors(['payment' => 'Invalid payment method']);
    }
    
    /**
     * Process credit card payment through Stripe
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function processCardPayment(Request $request, Booking $booking)
    {
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
                'payment_method' => 'credit_card',
                'payment_date' => now(),
            ]);

            return redirect()->route('bookings.receipt', $booking)->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            Log::error('Payment error: ' . $e->getMessage());
            return back()->withErrors(['payment' => 'Payment failed. Please try again.']);
        }
    }
    
    /**
     * Process PayPal payment
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Booking $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function processPayPalPayment(Request $request, Booking $booking)
    {
        // For demonstration, we'll simulate a successful PayPal payment
        // In a real application, you would integrate with PayPal API
        
        try {
            // Simulate successful payment
            $paymentId = 'PAYPAL-' . strtoupper(Str::random(10));
            
            $booking->update([
                'status' => 'confirmed',
                'payment_id' => $paymentId,
                'payment_method' => 'paypal',
                'payment_date' => now(),
            ]);
            
            return redirect()->route('bookings.receipt', $booking)->with('success', 'PayPal payment successful!');
        } catch (\Exception $e) {
            Log::error('PayPal payment error: ' . $e->getMessage());
            return back()->withErrors(['payment' => 'PayPal payment failed. Please try again.']);
        }
    }
    
    /**
     * Display the receipt after successful payment
     *
     * @param \App\Models\Booking $booking
     * @return \Illuminate\View\View
     */
    public function receipt(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->status === 'confirmed', 404, 'Receipt not found.');
        
        return view('bookings.receipt', compact('booking'));
    }

    public function create(Request $request, Room $room)
    {
        $checkIn = $request->query('check_in', now()->format('Y-m-d'));
        $checkOut = $request->query('check_out', now()->addDay()->format('Y-m-d'));
        
        return view('bookings.create', compact('room', 'checkIn', 'checkOut'));
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