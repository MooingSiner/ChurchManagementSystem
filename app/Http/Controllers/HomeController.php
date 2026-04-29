<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Members;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Exception;

class HomeController extends Controller
{
    protected function sessionIsOpenForMarking(AttendanceSession $session): bool
    {
        $openingDateTime = Carbon::parse(
            trim(($session->attendance_date ?? $session->event?->start_date ?? now()->toDateString()) . ' ' . ($session->time_in_start ?? $session->event?->start_time ?? '00:00')),
            'Asia/Manila'
        );
        $closingDateTime = Carbon::parse(
            trim(($session->attendance_date ?? $session->event?->start_date ?? now()->toDateString()) . ' ' . ($session->time_out_end ?? $session->event?->end_time ?? '23:59')),
            'Asia/Manila'
        );
        $now = Carbon::now('Asia/Manila');

        return $now->between($openingDateTime, $closingDateTime);
    }

    public function home()
{
    $now = Carbon::now('Asia/Manila');

    $events = Event::with('type')
        ->orderBy('start_date')
        ->orderBy('start_time')
        ->get();

    $events = $events->filter(function ($event) use ($now) {
        $startDateTime = Carbon::parse($event->start_date . ' ' . ($event->start_time ?? '00:00'), 'Asia/Manila');
        $endDateTime = Carbon::parse($event->end_date . ' ' . ($event->end_time ?? '23:59'), 'Asia/Manila');

        return $now->between($startDateTime, $endDateTime);
    })->values();

    $members = Members::where('is_archived', false)
        ->orderBy('member_fname')
        ->get();

    $eventIds = $events->pluck('event_id');

    $allAttendanceSessionsByEvent = AttendanceSession::with('event')
        ->whereIn('event_id', $eventIds)
        ->latest()
        ->get()
        ->groupBy('event_id');

    $attendanceSessionsByEvent = $allAttendanceSessionsByEvent
        ->map(function ($sessions) {
            return $sessions
                ->filter(fn ($session) => $this->sessionIsOpenForMarking($session))
                ->values();
        });

    $attendanceSessionIdsByEvent = $attendanceSessionsByEvent
        ->map(fn ($sessions) => $sessions->first()?->attendance_session_id)
        ->filter();

    $sessionIds = $attendanceSessionsByEvent
        ->pluck('attendance_session_id')
        ->filter()
        ->values();

    $attendanceMemberIds = Attendance::select('attendance_session_id', 'event_id', 'member_id')
        ->whereIn('attendance_session_id', $sessionIds)
        ->get();

    return view('home', compact(
        'events',
        'members',
        'attendanceMemberIds',
        'attendanceSessionsByEvent',
        'attendanceSessionIdsByEvent',
        'allAttendanceSessionsByEvent'
    ));
}
    
    public function submitAttendance(Request $request)
    {
        try{
        $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'member_id' => 'required|exists:members,member_id',
            'attendance_session_id' => 'nullable|exists:attendance_sessions,attendance_session_id',
        ]);

        $member = Members::where('member_id', $request->member_id)
            ->where('is_archived', false)
            ->firstOrFail();

        // Use provided session ID or get the latest
        if ($request->attendance_session_id) {
            $attendanceSession = AttendanceSession::where('attendance_session_id', $request->attendance_session_id)
                ->where('event_id', $request->event_id)
                ->first();
        } else {
            $attendanceSession = AttendanceSession::where('event_id', $request->event_id)
                ->latest()
                ->first();
        }

        if (!$attendanceSession) {
            return redirect()->route('home')
                ->with('error', 'No attendance has been created for this event yet.');
        }

        if (! $this->sessionIsOpenForMarking($attendanceSession->loadMissing('event'))) {
            return redirect()->route('home')
                ->with('error', 'Attendance for this session is unavailable right now. Please check the event attendance time window.');
        }

        Attendance::create([
            'attendance_session_id' => $attendanceSession->attendance_session_id,
            'event_id' => $request->event_id,
            'member_id' => $member->member_id,
            'admin_id' => 1,
            'attended_at' => now(),
            'status' => 'Pending',
        ]);

        return redirect()->route('home')
            ->with('success', 'Attendance submitted! Waiting for administrator approval.');
    }
    catch(Exception $e){
        $message = match (true) {
            $e instanceof ModelNotFoundException => 'That member is no longer active. Choose another member or ask an administrator to restore the record.',
            $e instanceof QueryException => 'Attendance has already been submitted for this session. Wait for approval or ask an administrator to review it.',
            default => 'Could not submit attendance right now. Check the selected event/session and try again.',
        };

        return redirect()->route('home')
            ->with('error', $message);
    }
    }
}
