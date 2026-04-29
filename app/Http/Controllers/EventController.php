<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Exception;

class EventController extends Controller
{
    protected function eventErrorMessage(Exception $e, string $action): string
    {
        if ($e instanceof ModelNotFoundException) {
            return 'That event could not be found. Refresh the page and try again.';
        }

        return match ($action) {
            'create' => 'Could not create the event. Check the event dates, times, and type, then try again.',
            'update' => 'Could not update the event. Make sure the end date/time is after the start and try again.',
            'delete' => 'Could not delete the event right now. Refresh the list and try again.',
            'finish' => 'Could not mark the event as completed. Refresh the page and try again.',
            default => 'Could not save the event right now. Please try again.',
        };
    }

    protected function validateEvent(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'type_id' => 'required|integer|exists:types,type_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'description' => 'nullable|string',
        ]);

        $validator->after(function ($validator) use ($request) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $startTime = $request->input('start_time');
            $endTime = $request->input('end_time');

            if ($startDate && $endDate && $startTime && $endTime && $startDate === $endDate && $endTime <= $startTime) {
                $validator->errors()->add('end_time', 'End time must be later than start time for same-day events.');
            }
        });

        return $validator->validate();
    }

    protected function resolveEventStatus(array $validatedData): string
    {
        $now = Carbon::now('Asia/Manila');
        $startDateTime = Carbon::parse($validatedData['start_date'] . ' ' . $validatedData['start_time'], 'Asia/Manila');
        $endDateTime = Carbon::parse($validatedData['end_date'] . ' ' . $validatedData['end_time'], 'Asia/Manila');

        if ($now->lt($startDateTime)) {
            return 'upcoming';
        }

        if ($now->between($startDateTime, $endDateTime)) {
            return 'ongoing';
        }

        return 'finished';
    }

    public function event()
    {
        $events = Event::with(['type', 'admin'])->latest()->get();
        $types = EventType::all();

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
    $types = EventType::all();

    return view('events', compact('events', 'types'));
}
    public function create()
    {
        $types = EventType::all();
        return view('events.create', compact('types'));
    }

   public function store(Request $request)
{
    try {
        $validatedData = $this->validateEvent($request);

        Event::create([
            'event_name' => $validatedData['event_name'],
            'type_id' => $validatedData['type_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'description' => $validatedData['description'] ?? null,
            'admin_id' => Auth::user()->admin_id,
            'status' => $this->resolveEventStatus($validatedData),
        ]);

        return redirect()->back()->with('success', 'Event created successfully');

    } catch (ValidationException $e) {
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput()
            ->with('error', 'Please fix the highlighted event details and try again.');
    } catch (Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->eventErrorMessage($e, 'create'));
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
        $types = EventType::all();

        return view('events.edit', compact('event', 'types'));
    }

    public function update(Request $request, $id)
    {
        try{
        $event = Event::findOrFail($id);

        $validatedData = $this->validateEvent($request);

        $event->update([
            'event_name' => $validatedData['event_name'],
            'type_id' => $validatedData['type_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'description' => $validatedData['description'] ?? null,
            'status' => $this->resolveEventStatus($validatedData),
        ]);

        return redirect()->back()->with('success', 'Event Updated successfully');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please fix the highlighted event details and try again.');
        }catch(Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->eventErrorMessage($e, 'update'));
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
                ->with('error', $this->eventErrorMessage($e, 'delete'));
        }

    }
    public function finish($id)
{
    try{
    $event = Event::findOrFail($id);

    $now = Carbon::now('Asia/Manila');
    $startDateTime = Carbon::parse($event->start_date . ' ' . $event->start_time, 'Asia/Manila');
    $endDateTime = Carbon::parse($event->end_date . ' ' . $event->end_time, 'Asia/Manila');

    if ($event->status === 'finished' || $now->gte($endDateTime)) {
        return redirect()->back()->with('error', 'This event is already finished.');
    }

    if ($now->lt($startDateTime)) {
        return redirect()->back()->with('error', 'This event has not started yet. Wait until the start time before marking it as completed.');
    }

    $event->update([
        'status' => 'finished'
    ]);

    return redirect()->back()->with('success', 'Event marked as ended');
} catch(Exception $e) {
    return redirect()->back()
        ->withInput()
        ->with('error', $this->eventErrorMessage($e, 'finish'));
}
}
}
