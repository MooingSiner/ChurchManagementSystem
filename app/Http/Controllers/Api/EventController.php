<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['type', 'admin'])->get();

        return response()->json([
            'success' => true,
            'data' => $events,
        ]);
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'event_name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'description' => 'nullable|string',
        'type_id' => 'required|integer|exists:types,type_id',
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

    $event = Event::create([
        'event_name' => $validatedData['event_name'],
        'start_date' => $validatedData['start_date'],
        'end_date' => $validatedData['end_date'],
        'start_time' => $validatedData['start_time'],
        'end_time' => $validatedData['end_time'],
        'description' => $validatedData['description'] ?? null,
        'type_id' => $validatedData['type_id'],
        'admin_id' => Auth::user()->admin_id,
        'status' => $status,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Event created successfully.',
        'data' => $event->load(['type', 'admin']),
    ], 201);
}

    public function show(string $id)
    {
        $event = Event::with(['type', 'admin', 'attendances'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $event,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'nullable|string',
            'type_id' => 'required|integer|exists:types,type_id',
        ]);

        $event->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully.',
            'data' => $event->load(['type', 'admin']),
        ]);
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully.',
        ]);
    }
    
}