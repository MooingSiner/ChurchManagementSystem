<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
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
        $attendanceQuery = Attendance::query()->where('status', 'Present');

        if ($fromDate) {
            $eventsQuery->whereDate('start_date', '>=', $fromDate);
            $attendanceQuery->whereDate('attended_at', '>=', $fromDate);
        }

        $totalMembers = $membersQuery->count();
        $totalEvents = $eventsQuery->count();
        $totalAttendance = $attendanceQuery->count();
        $avgAttendance = $totalEvents > 0 ? round($totalAttendance / $totalEvents) : 0;

        $reportHistoryQuery = Event::with('type')
            ->withCount([
                'attendances as approved_attendance_count' => function ($query) use ($fromDate) {
                    $query->where('status', 'Present');

                    if ($fromDate) {
                        $query->whereDate('attended_at', '>=', $fromDate);
                    }
                }
            ])
            ->orderByDesc('start_date');

        if ($fromDate) {
            $reportHistoryQuery->whereDate('start_date', '>=', $fromDate);
        }

        $reportHistory = $reportHistoryQuery->get();

        $attendanceByEvent = Event::withCount([
                'attendances as approved_attendance_count' => function ($query) use ($fromDate) {
                    $query->where('status', 'Present');

                    if ($fromDate) {
                        $query->whereDate('attended_at', '>=', $fromDate);
                    }
                }
            ])
            ->orderBy('start_date')
            ->get()
            ->map(function ($event) {
                return [
                    'label' => $event->event_name,
                    'count' => $event->approved_attendance_count,
                ];
            });

        $attendanceByTypeQuery = DB::table('events')
            ->join('types', 'events.type_id', '=', 'types.type_id')
            ->leftJoin('attendances', function ($join) use ($fromDate) {
                $join->on('events.event_id', '=', 'attendances.event_id')
                     ->where('attendances.status', '=', 'Present');

                if ($fromDate) {
                    $join->whereDate('attendances.attended_at', '>=', $fromDate);
                }
            })
            ->select('types.type_name', DB::raw('COUNT(attendances.attendance_id) as total'))
            ->groupBy('types.type_id', 'types.type_name')
            ->get();

        $memberStatus = [
            'attended' => Attendance::where('status', 'Present')
                ->when($fromDate, fn ($q) => $q->whereDate('attended_at', '>=', $fromDate))
                ->distinct('member_id')
                ->count('member_id'),
            'not_attended' => max(
                0,
                $totalMembers - Attendance::where('status', 'Present')
                    ->when($fromDate, fn ($q) => $q->whereDate('attended_at', '>=', $fromDate))
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