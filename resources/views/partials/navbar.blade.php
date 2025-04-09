<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">Hotel Booking</a>
            
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('bookings.index') }}" class="text-gray-600 hover:text-gray-800">My Bookings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-800">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>