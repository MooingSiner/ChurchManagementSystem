<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Event;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class AttendanceController extends Controller
{
    public function attendance(Request $request)
    {
        $events = Event::with('type')
            ->orderBy('start_date', 'desc')
            ->get();

        $attendanceSessions = AttendanceSession::with(['event.type'])
            ->withCount([
                'attendances as approved_attendance_count' => function ($query) {
                    $query->where('status', 'Present');
                },
                'attendances as pending_attendance_count' => function ($query) {
                    $query->where('status', 'Pending');
                },
            ])
            ->latest()
            ->get();

        $selectedSessionId = $request->attendance_session_id;
        $isMarkingAttendance = false;

        $selectedSession = null;
        $selectedEvent = null;
        $approvedAttendances = collect();
        $pendingAttendances = collect();
        $availableMembers = collect();

        if ($selectedSessionId) {
            $selectedSession = AttendanceSession::with(['event.type'])->find($selectedSessionId);
            $selectedEvent = $selectedSession?->event;
            $isMarkingAttendance = $request->view === 'mark' && $selectedSession;

            $approvedAttendances = Attendance::with('member')
                ->where('attendance_session_id', $selectedSessionId)
                ->where('status', 'Present')
                ->latest('attended_at')
                ->get();

            $pendingAttendances = Attendance::with('member')
                ->where('attendance_session_id', $selectedSessionId)
                ->where('status', 'Pending')
                ->latest('attended_at')
                ->get();

            $alreadyAddedMemberIds = Attendance::where('attendance_session_id', $selectedSessionId)
                ->pluck('member_id');

            $availableMembers = Members::whereNotIn('member_id', $alreadyAddedMemberIds)->get();
        }

        $totalApproved = $approvedAttendances->count();
        $totalPending = $pendingAttendances->count();
        $totalRecords = $totalApproved + $totalPending;

        return view('attendance', compact(
            'events',
            'attendanceSessions',
            'selectedSession',
            'selectedEvent',
            'approvedAttendances',
            'pendingAttendances',
            'availableMembers',
            'totalApproved',
            'totalPending',
            'totalRecords',
            'isMarkingAttendance'
        ));
    }

    public function storeSession(Request $request)
    {
        try {
            $validated = $request->validate([
                'event_id' => 'required|exists:events,event_id',
                'attendance_name' => 'required|string|max:255',
                'attendance_date' => 'nullable|date',
                'time_in_start' => 'nullable|date_format:H:i',
                'time_out_end' => 'nullable|date_format:H:i',
            ]);

            $event = Event::findOrFail($validated['event_id']);

            $session = AttendanceSession::create([
                'event_id' => $event->event_id,
                'admin_id' => Auth::id(),
                'attendance_name' => $validated['attendance_name'],
                'attendance_date' => $validated['attendance_date'] ?? $event->start_date,
                'time_in_start' => $validated['time_in_start'] ?? null,
                'time_out_end' => $validated['time_out_end'] ?? null,
            ]);

            return redirect()
                ->route('attendance', ['attendance_session_id' => $session->attendance_session_id])
                ->with('success', 'Attendance created successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create attendance. Please check the details and try again.');
        }
    }

    public function addManual(Request $request)
    {
        try{
        $validated = $request->validate([
            'attendance_session_id' => 'required|exists:attendance_sessions,attendance_session_id',
            'member_id' => 'required|exists:members,member_id',
        ]);

        $session = AttendanceSession::findOrFail($validated['attendance_session_id']);

        Attendance::updateOrCreate(
            [
                'attendance_session_id' => $session->attendance_session_id,
                'member_id' => $validated['member_id'],
            ],
            [
                'event_id' => $session->event_id,
                'admin_id' => Auth::id(),
                'attended_at' => now(),
                'time_in' => now(),
                'status' => 'Present',
            ]
        );

        return redirect()->back()->with('success', 'Attendance added successfully.');
        }catch(Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to add attendance. Please check the details and try again.');
        }
    }

    public function approve($id)
    {
        try{
        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'status' => 'Present',
            'admin_id' => Auth::id(),
            'attended_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Attendance approved.');
        }catch(Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to approve to attendance. Please check the details and try again.');
    }
    }

    public function reject($id)
    {
        try{
        $attendance = Attendance::findOrFail($id);
        $eventId = $attendance->event_id;
        $attendance->delete();

        return redirect()->back()->with('error', 'Attendance rejected.');
        }catch
        (Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to reject member to attendance. Please check the details and try again.');
    }
    }

    public function destroy($id)
    {
        try{
        $attendance = Attendance::findOrFail($id);
        $eventId = $attendance->event_id;
        $attendance->delete();

        return redirect()->back()->with('error', 'Attendance removed.');
        }catch(Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to remove member from attendance. Please check the details and try again.');
    }
    }
}
