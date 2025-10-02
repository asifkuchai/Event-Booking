<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Number of events booked by the user
        $eventsBookedCount = Booking::where('user_id', $user->id)->count();

        // Top 5 upcoming events
        $upcomingEvents = Event::where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        // Occupancy for all events
        $eventsWithOccupancy = Event::all()->map(function ($event) {
            $bookedTickets = $event->bookings()->sum('tickets');
            $occupancy = $event->capacity > 0 ? ($bookedTickets / $event->capacity) * 100 : 0;
            $event->occupancy = round($occupancy, 2);
            return $event;
        });

        // Users who booked more than 3 events last month
        $lastMonth = Carbon::now()->subMonth();
        $activeUsers = User::whereHas('bookings', function($query) use ($lastMonth) {
            $query->whereMonth('created_at', $lastMonth->month)
                  ->whereYear('created_at', $lastMonth->year);
        })
        ->withCount(['bookings' => function($query) use ($lastMonth) {
            $query->whereMonth('created_at', $lastMonth->month)
                  ->whereYear('created_at', $lastMonth->year);
        }])
        ->having('bookings_count', '>', 3)
        ->get();

        return view('dashboard', compact(
            'user',
            'eventsBookedCount',
            'upcomingEvents',
            'eventsWithOccupancy',
            'activeUsers' // <-- pass active users to the view
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }
}
