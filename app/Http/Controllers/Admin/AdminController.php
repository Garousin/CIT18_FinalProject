<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Count statistics
        $totalRooms = Room::count();
        $totalUsers = User::where('is_admin', false)->count();
        $totalBookings = Booking::count();
        $revenue = Booking::where('status', 'confirmed')->sum('total_price');
        
        // Recent bookings
        $recentBookings = Booking::with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();
            
        // Booking status distribution
        $bookingStatusCounts = Booking::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        // Monthly revenue for the current year
        $currentYear = date('Y');
        
        // Use SQLite-compatible date functions for extracting month
        $monthlyRevenue = Booking::where('status', 'confirmed')
            ->where(DB::raw("strftime('%Y', created_at)"), $currentYear)
            ->select(
                DB::raw("strftime('%m', created_at) as month"), 
                DB::raw("SUM(total_price) as revenue")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();
            
        // Fill in missing months with zero
        for ($i = 1; $i <= 12; $i++) {
            $padded_i = str_pad($i, 2, '0', STR_PAD_LEFT); // Convert 1 to '01', etc.
            if (!isset($monthlyRevenue[$padded_i])) {
                $monthlyRevenue[$padded_i] = 0;
            }
        }
        ksort($monthlyRevenue);
        
        return view('admin.dashboard', compact(
            'totalRooms', 
            'totalUsers', 
            'totalBookings', 
            'revenue', 
            'recentBookings',
            'bookingStatusCounts',
            'monthlyRevenue'
        ));
    }
} 