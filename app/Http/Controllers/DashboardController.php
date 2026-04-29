<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\Event;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalMembers = Members::where('is_archived', false)->count();
        $archivedMembers = Members::where('is_archived', true)->count();

        $totalEvents = Event::count();

        $attendanceRecords = Attendance::where('status', 'Present')->count();

        $averageAttendance = $totalEvents > 0
            ? round($attendanceRecords / $totalEvents)
            : 0;

        $recentEvents = Event::withCount([
            'attendances as attendance_count' => function ($query) {
                $query->where('status', 'Present');
            }
        ])
        ->orderByDesc('start_date')
        ->take(5)
        ->get();

        return view('dashboard', compact(
            'totalMembers',
            'archivedMembers',
            'totalEvents',
            'attendanceRecords',
            'averageAttendance',
            'recentEvents'
        ));
    }
}