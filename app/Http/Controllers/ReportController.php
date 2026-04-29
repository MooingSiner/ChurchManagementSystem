<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Event;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $range = $request->get('range', '30days');

        $fromDate = match ($range) {
            '7days' => now()->subDays(7),
            '30days' => now()->subDays(30),
            '90days' => now()->subDays(90),
            default => null,
        };

        $membersQuery = Members::query();
        $eventsQuery = Event::query();
        $attendanceSessionsQuery = AttendanceSession::query();
        $attendanceQuery = Attendance::query()
            ->where('status', 'Present')
            ->whereHas('attendanceSession', function ($query) use ($fromDate) {
                if ($fromDate) {
                    $query->whereDate('attendance_date', '>=', $fromDate);
                }
            });

        if ($fromDate) {
            $eventsQuery->whereDate('start_date', '>=', $fromDate);
            $attendanceSessionsQuery->whereDate('attendance_date', '>=', $fromDate);
        }

        $totalMembers = $membersQuery->count();
        $totalEvents = $eventsQuery->count();
        $totalAttendanceSessions = $attendanceSessionsQuery->count();
        $totalAttendance = $attendanceQuery->count();
        $avgAttendance = $totalAttendanceSessions > 0 ? round($totalAttendance / $totalAttendanceSessions) : 0;

        $reportHistoryQuery = AttendanceSession::with(['event.type'])
            ->withCount([
                'attendances as approved_attendance_count' => function ($query) use ($fromDate) {
                    $query->where('status', 'Present');

                    if ($fromDate) {
                        $query->whereHas('attendanceSession', function ($sessionQuery) use ($fromDate) {
                            $sessionQuery->whereDate('attendance_date', '>=', $fromDate);
                        });
                    }
                }
            ])
            ->orderByDesc('attendance_date')
            ->latest();

        if ($fromDate) {
            $reportHistoryQuery->whereDate('attendance_date', '>=', $fromDate);
        }

        $reportHistory = $reportHistoryQuery->get();

        $attendanceByEventQuery = DB::table('attendance_sessions')
            ->join('events', 'attendance_sessions.event_id', '=', 'events.event_id')
            ->leftJoin('attendances', function ($join) {
                $join->on('attendance_sessions.attendance_session_id', '=', 'attendances.attendance_session_id')
                    ->where('attendances.status', '=', 'Present');
            });

        if ($fromDate) {
            $attendanceByEventQuery->whereDate('attendance_sessions.attendance_date', '>=', $fromDate);
        }

        $attendanceByEvent = $attendanceByEventQuery
            ->select('events.event_name as label', DB::raw('COUNT(attendances.attendance_id) as count'))
            ->groupBy('events.event_id', 'events.event_name')
            ->orderBy('events.event_name')
            ->get();

        $attendanceByTypeQuery = DB::table('attendance_sessions')
            ->join('events', 'attendance_sessions.event_id', '=', 'events.event_id')
            ->join('types', 'events.type_id', '=', 'types.type_id')
            ->leftJoin('attendances', function ($join) use ($fromDate) {
                $join->on('attendance_sessions.attendance_session_id', '=', 'attendances.attendance_session_id')
                     ->where('attendances.status', '=', 'Present');
            });

        if ($fromDate) {
            $attendanceByTypeQuery->whereDate('attendance_sessions.attendance_date', '>=', $fromDate);
        }

        $attendanceByTypeQuery = $attendanceByTypeQuery
            ->select('types.type_name', DB::raw('COUNT(attendances.attendance_id) as total'))
            ->groupBy('types.type_id', 'types.type_name')
            ->get();

        $memberStatus = [
            'attended' => Attendance::where('status', 'Present')
                ->whereHas('attendanceSession', function ($query) use ($fromDate) {
                    if ($fromDate) {
                        $query->whereDate('attendance_date', '>=', $fromDate);
                    }
                })
                ->distinct('member_id')
                ->count('member_id'),
            'not_attended' => max(
                0,
                $totalMembers - Attendance::where('status', 'Present')
                    ->whereHas('attendanceSession', function ($query) use ($fromDate) {
                        if ($fromDate) {
                            $query->whereDate('attendance_date', '>=', $fromDate);
                        }
                    })
                    ->distinct('member_id')
                    ->count('member_id')
            ),
        ];

        return view('report', compact(
            'range',
            'totalMembers',
            'totalEvents',
            'totalAttendance',
            'avgAttendance',
            'reportHistory',
            'attendanceByEvent',
            'attendanceByTypeQuery',
            'memberStatus'
        ));
    }
}
