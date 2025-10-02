<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List events with search, filter, pagination + caching
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $venue = $request->input('venue', '');
        $from_date = $request->input('from_date', '');
        $to_date = $request->input('to_date', '');

        // Unique cache key per filter & page
        $cacheKey = 'events_' . md5($page . $search . $venue . $from_date . $to_date);

        $events = Cache::remember($cacheKey, 300, function() use ($search, $venue, $from_date, $to_date) {
            $query = Event::query();

            if (!empty($search)) {
                $query->where('title', 'like', '%' . $search . '%');
            }

            if (!empty($venue)) {
                $query->where('venue', $venue);
            }

            if (!empty($from_date) && !empty($to_date)) {
                $query->whereBetween('event_date', [$from_date, $to_date]);
            }

            return $query->orderBy('event_date', 'asc')->paginate(10);
        });

        return view('events.index', compact('events'))
               ->with('search', $search)
               ->with('venue', $venue)
               ->with('from_date', $from_date)
               ->with('to_date', $to_date);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'event_date' => 'required|date',
        ]);

        Event::create($request->all());

        // Clear all event cache
        Cache::flush();

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'event_date' => 'required|date',
        ]);

        $event->update($request->all());

        // Clear all event cache
        Cache::flush();

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        // Clear all event cache
        Cache::flush();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
