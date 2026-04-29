<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

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
    Event::all()->each(function ($event) {
        $now = Carbon::now('Asia/Manila');

        $startDateTime = Carbon::parse($event->start_date . ' ' . $event->start_time, 'Asia/Manila');
        $endDateTime = Carbon::parse($event->end_date . ' ' . $event->end_time, 'Asia/Manila');

        if ($now->lt($startDateTime)) {
            $event->update(['status' => 'upcoming']);
        } elseif ($now->between($startDateTime, $endDateTime)) {
            $event->update(['status' => 'ongoing']);
        } else {
            $event->update(['status' => 'finished']);
        }
    });

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
    try {
        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255',
            'type_id' => 'required|integer|exists:types,type_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'nullable|string',
        ]);

        $now = Carbon::now('Asia/Manila');
        $startDateTime = Carbon::parse($validatedData['start_date'] . ' ' . $validatedData['start_time'], 'Asia/Manila');
        $endDateTime = Carbon::parse($validatedData['end_date'] . ' ' . $validatedData['end_time'], 'Asia/Manila');

        if ($now->lt($startDateTime)) {
            $status = 'upcoming';
        } elseif ($now->between($startDateTime, $endDateTime)) {
            $status = 'ongoing';
        } else {
            $status = 'finished';
        }

        Event::create([
            'event_name' => $validatedData['event_name'],
            'type_id' => $validatedData['type_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'description' => $validatedData['description'] ?? null,
            'admin_id' => Auth::user()->admin_id,
            'status' => $status,
        ]);

        return redirect()->back()->with('success', 'Event created successfully');

    } catch (Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to add Event. Invalid details provided.');
    }
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
        try{
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

        return redirect()->back()->with('success', 'Event Updated successfully');
        }catch(Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to Update Event. Please check the details and try again.');
        }
    }

    public function destroy($id)
    {
        try{
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('error', 'Event deleted successfully');
        }catch(Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to delete Event. Please check the details and try again.');
        }

    }
    public function finish($id)
{
    try{
    $event = Event::findOrFail($id);

    $event->update([
        'status' => 'finished'
    ]);

    return redirect()->back()->with('success', 'Event marked as completed');
} catch(Exception $e) {
    return redirect()->back()
        ->withInput()
        ->with('error', 'Failed to mark event as completed. Please check the details and try again.');
}
}
}