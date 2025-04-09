<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
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
        $monthlyRevenue = Booking::where('status', 'confirmed')
            ->whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as revenue'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();
            
        // Fill in missing months with zero
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyRevenue[$i])) {
                $monthlyRevenue[$i] = 0;
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