<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Members;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use Exception;

class HomeController extends Controller
{
    public function home()
{
    $events = Event::with('type')
        ->whereIn('status', ['upcoming', 'ongoing'])
        ->orderBy('start_date')
        ->orderBy('start_time')
        ->get();

    $members = Members::where('is_archived', false)
        ->orderBy('member_fname')
        ->get();

    $eventIds = $events->pluck('event_id');

    $attendanceSessionsByEvent = AttendanceSession::whereIn('event_id', $eventIds)
        ->latest()
        ->get()
        ->groupBy('event_id');

    $attendanceSessionIdsByEvent = $attendanceSessionsByEvent
        ->map(fn ($sessions) => $sessions->first()->attendance_session_id);

    $sessionIds = $attendanceSessionsByEvent
        ->pluck('attendance_session_id')
        ->filter()
        ->values();

    $attendanceMemberIds = Attendance::select('attendance_session_id', 'event_id', 'member_id')
        ->whereIn('attendance_session_id', $sessionIds)
        ->get();

    return view('home', compact('events', 'members', 'attendanceMemberIds', 'attendanceSessionsByEvent', 'attendanceSessionIdsByEvent'));
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
        return redirect()->route('home')
            ->with('error', 'Attendance already submitted for this event.');
    }
    }
}
