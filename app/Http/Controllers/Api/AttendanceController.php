<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function attendance(Request $request)
    {
        $events = Event::with('type')->orderBy('start_date', 'desc')->get();

        $selectedEventId = $request->event_id ?? $events->first()?->event_id;

        $selectedEvent = null;
        $approvedAttendances = collect();
        $pendingAttendances = collect();
        $availableMembers = collect();

        if ($selectedEventId) {
            $selectedEvent = Event::with('type')->find($selectedEventId);

            $approvedAttendances = Attendance::with('member')
                ->where('event_id', $selectedEventId)
                ->where('status', 'Present')
                ->orderByDesc('attended_at')
                ->get();

            $pendingAttendances = Attendance::with('member')
                ->where('event_id', $selectedEventId)
                ->where('status', 'Pending')
                ->orderByDesc('attended_at')
                ->get();

            $alreadyAddedMemberIds = Attendance::where('event_id', $selectedEventId)
                ->pluck('member_id');

            $availableMembers = Members::whereNotIn('member_id', $alreadyAddedMemberIds)
                ->orderBy('member_fname')
                ->get();
        }

        $totalApproved = $approvedAttendances->count();
        $totalPending = $pendingAttendances->count();
        $totalRecords = $totalApproved + $totalPending;

        return view('attendance', compact(
            'events',
            'selectedEvent',
            'approvedAttendances',
            'pendingAttendances',
            'availableMembers',
            'totalApproved',
            'totalPending',
            'totalRecords'
        ));
    }

    public function addManual(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'member_id' => 'required|exists:members,member_id',
        ]);

        Attendance::updateOrCreate(
            [
                'event_id' => $validated['event_id'],
                'member_id' => $validated['member_id'],
            ],
            [
                'admin_id' => Auth::id(),
                'attended_at' => now(),
                'status' => 'Present',
            ]
        );

        return redirect()->route('attendance', ['event_id' => $validated['event_id']])
            ->with('success', 'Attendance added successfully.');
    }

    public function approve($id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->update([
            'status' => 'Present',
            'admin_id' => Auth::id(),
            'attended_at' => now(),
        ]);

        return redirect()->route('attendance', ['event_id' => $attendance->event_id])
            ->with('success', 'Attendance approved.');
    }

    public function reject($id)
    {
        $attendance = Attendance::findOrFail($id);
        $eventId = $attendance->event_id;

        $attendance->delete();

        return redirect()->route('attendance', ['event_id' => $eventId])
            ->with('success', 'Attendance rejected.');
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $eventId = $attendance->event_id;

        $attendance->delete();

        return redirect()->route('attendance', ['event_id' => $eventId])
            ->with('success', 'Attendance removed.');
    }
}