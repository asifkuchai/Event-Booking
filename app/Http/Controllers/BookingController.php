<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Index page with bookings and events filter
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Booking::with('event')->where('user_id', $userId);

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('event', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        }

        if ($request->event_id) {
            $query->where('event_id', $request->event_id);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);
        $events = Event::orderBy('title')->get();

        return view('bookings.index', compact('bookings', 'events'));
    }

    // Show booking form
    public function create()
    {
        $events = Event::orderBy('title')->get();
        return view('bookings.create', compact('events'));
    }

    // Store booking with overbooking prevention
   public function store(Request $request)
{
    $request->validate([
        'event_id' => 'required|exists:events,id',
        'tickets' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();
    try {
        // Lock the event row for safe concurrent booking
        $event = Event::where('id', $request->event_id)->lockForUpdate()->firstOrFail();

        $totalBooked = $event->bookings()->sum('tickets');
        $availableSeats = $event->capacity - $totalBooked;

        if ($request->tickets > $availableSeats) {
            return back()->withErrors(['tickets' => "Only $availableSeats tickets available."]);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'tickets' => $request->tickets,
        ]);

        // Commit DB transaction first
        DB::commit();

        // Queue confirmation email AFTER successful booking
        Mail::to(Auth::user()->email)->queue(new BookingConfirmation($booking));

        return redirect()->route('bookings.index')->with('success', 'Booking successful! A confirmation email has been sent.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['tickets' => 'Booking failed, please try again.']);
    }
}

    // Show single booking
    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function createForEvent(Event $event)
    {
        // Pass only this event to the view, and mark it as selected
        return view('bookings.create', [
            'events' => collect([$event]), // only this event
            'selectedEvent' => $event->id,
        ]);
    }


    // Edit booking
    public function edit(Booking $booking)
    {
        $events = Event::orderBy('title')->get();
        $users = \App\Models\User::orderBy('name')->get();
        return view('bookings.edit', compact('booking', 'events', 'users'));
    }

    // Update booking with overbooking prevention
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'tickets' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $event = Event::where('id', $request->event_id)->lockForUpdate()->firstOrFail();

            // Calculate available seats excluding the current booking
            $totalBooked = $event->bookings()->sum('tickets') - $booking->tickets;
            $availableSeats = $event->capacity - $totalBooked;

            if ($request->tickets > $availableSeats) {
                return back()->withErrors(['tickets' => "Only $availableSeats tickets available."]);
            }

            $booking->update([
                'event_id' => $event->id,
                'tickets' => $request->tickets,
            ]);

            DB::commit();
            return redirect()->route('bookings.index')->with('success', 'Booking updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['tickets' => 'Update failed, please try again.']);
        }
    }

    // Delete booking
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted!');
    }
}
