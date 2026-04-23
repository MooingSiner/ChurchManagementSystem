<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function event()
    {
        $events = Event::with(['type', 'admin'])->latest()->get();
        $types = Type::all();

        return view('events', compact('events', 'types'));
    }

    public function index()
    {
        $events = Event::with(['type', 'admin'])->latest()->get();
        $types = Type::all();

        return view('events', compact('events', 'types'));
    }

    public function create()
    {
        $types = Type::all();
        return view('events.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255',
            'type_id' => 'required|integer|exists:types,type_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'nullable|string',
        ]);

        Event::create([
            'event_name' => $validatedData['event_name'],
            'type_id' => $validatedData['type_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'description' => $validatedData['description'] ?? null,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    public function show($id)
    {
        $event = Event::with(['type', 'admin', 'attendances'])->findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $types = Type::all();

        return view('events.edit', compact('event', 'types'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255',
            'type_id' => 'required|integer|exists:types,type_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'nullable|string',
        ]);

        $event->update([
            'event_name' => $validatedData['event_name'],
            'type_id' => $validatedData['type_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'description' => $validatedData['description'] ?? null,
        ]);

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }
    public function finish($id)
{
    $event = Event::findOrFail($id);

    $event->update([
        'status' => 'finished'
    ]);

    return redirect()->route('events.index')->with('success', 'Event marked as finished.');
}
}