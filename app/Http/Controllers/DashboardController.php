<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\Event;
use App\Models\Attendance;
use App\Models\AttendanceSession;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalMembers = Members::where('is_archived', false)->count();
        $archivedMembers = Members::where('is_archived', true)->count();

        $totalEvents = Event::count();

        $attendanceRecords = Attendance::where('status', 'Present')
            ->whereNotNull('attendance_session_id')
            ->count();

        $totalAttendanceSessions = AttendanceSession::count();

        $averageAttendance = $totalAttendanceSessions > 0
            ? round($attendanceRecords / $totalAttendanceSessions)
            : 0;

        $recentAttendanceSessions = AttendanceSession::with('event')
            ->withCount([
            'attendances as attendance_count' => function ($query) {
                $query->where('status', 'Present');
            }
        ])
        ->orderByDesc('attendance_sessions.attendance_date')
        ->orderByDesc('attendance_sessions.created_at')
        ->select('attendance_sessions.*')
        ->latest()
        ->take(5)
        ->get();

        return view('dashboard', compact(
            'totalMembers',
            'archivedMembers',
            'totalEvents',
            'attendanceRecords',
            'totalAttendanceSessions',
            'averageAttendance',
            'recentAttendanceSessions'
        ));
    }
}
