<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Event;
use App\Models\Members;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['member', 'event', 'admin'])
            ->latest('attended_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $attendances,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'member_id' => 'required|exists:members,member_id',
            'status' => 'nullable|string',
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'event_id' => $validated['event_id'],
                'member_id' => $validated['member_id'],
            ],
            [
                'admin_id' => Auth::id(),
                'attended_at' => now(),
                'status' => $validated['status'] ?? 'Present',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Attendance saved successfully.',
            'data' => $attendance->load(['member', 'event', 'admin']),
        ], 201);
    }

    public function show(string $id)
    {
        $attendance = Attendance::with(['member', 'event', 'admin'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $attendance,
        ]);
    }

    public function scanAttendance(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'member_id' => 'required|integer|exists:members,member_id',
            'attendance_session_id' => 'nullable|exists:attendance_sessions,attendance_session_id',
        ]);

        $member = Members::where('member_id', $validated['member_id'])
            ->where('is_archived', false)
            ->first();

        if (! $member) {
            return response()->json([
                'success' => false,
                'error' => 'Member is not active.',
            ], 404);
        }

        $attendanceSessionQuery = AttendanceSession::where('event_id', $validated['event_id']);

        if (! empty($validated['attendance_session_id'])) {
            $attendanceSessionQuery->where('attendance_session_id', $validated['attendance_session_id']);
        }

        $attendanceSession = $attendanceSessionQuery->latest('attendance_session_id')->first();

        if (! $attendanceSession) {
            return response()->json([
                'success' => false,
                'error' => 'No attendance session is available for this event yet.',
            ], 422);
        }

        $existingAttendance = Attendance::where('attendance_session_id', $attendanceSession->attendance_session_id)
            ->where('member_id', $member->member_id)
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'error' => 'Attendance already submitted for this session.',
                'data' => $existingAttendance,
            ], 409);
        }

        try {
            $attendance = Attendance::create([
                'attendance_session_id' => $attendanceSession->attendance_session_id,
                'event_id' => $attendanceSession->event_id,
                'member_id' => $member->member_id,
                'admin_id' => Auth::id() ?: 1,
                'attended_at' => now(),
                'time_in' => now(),
                'status' => 'Pending',
            ]);
        } catch (QueryException $exception) {
            return response()->json([
                'success' => false,
                'error' => 'Attendance already submitted for this session.',
            ], 409);
        }

        return response()->json([
            'success' => true,
            'message' => 'Attendance submitted successfully.',
            'data' => $attendance->load(['member', 'event', 'attendanceSession']),
        ], 201);
    }

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
