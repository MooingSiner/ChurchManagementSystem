<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Event;
use App\Models\Members;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Exception;

class AttendanceController extends Controller
{
    protected function normalizeDateInput(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        foreach (['Y-m-d', 'm/d/Y', 'n/j/Y'] as $format) {
            try {
                return Carbon::createFromFormat($format, $value)->format('Y-m-d');
            } catch (Exception) {
            }
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (Exception) {
            return $value;
        }
    }

    protected function normalizeTimeInput(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        foreach (['H:i', 'H:i:s', 'g:i A', 'g:iA', 'h:i A', 'h:iA'] as $format) {
            try {
                return Carbon::createFromFormat($format, trim($value))->format('H:i');
            } catch (Exception) {
            }
        }

        try {
            return Carbon::parse($value)->format('H:i');
        } catch (Exception) {
            return $value;
        }
    }

    protected function validateSessionData(Request $request, bool $enforceTodayOrLater = false): array
    {
        $request->merge([
            'attendance_date' => $this->normalizeDateInput($request->input('attendance_date')),
            'time_in_start' => $this->normalizeTimeInput($request->input('time_in_start') ?: '08:00'),
            'time_out_end' => $this->normalizeTimeInput($request->input('time_out_end') ?: '18:00'),
        ]);

        $eventId = $request->input('event_id');
        $event = $eventId ? Event::find($eventId) : null;

        $validator = validator($request->all(), [
            'attendance_name' => 'required|string|max:255',
            'attendance_date' => 'required|date' . ($enforceTodayOrLater ? '|after_or_equal:today' : ''),
            'time_in_start' => 'nullable|date_format:H:i',
            'time_out_end' => 'nullable|date_format:H:i',
        ]);

        $validator->after(function ($validator) use ($request, $event) {
            $timeIn = $request->input('time_in_start');
            $timeOut = $request->input('time_out_end');

            if ($timeIn && $timeOut && $timeOut <= $timeIn) {
                $validator->errors()->add('time_out_end', 'Time out must be later than time in.');
            }

            if ($event && $request->filled('attendance_date')) {
                $attendanceDate = Carbon::parse($request->input('attendance_date'));
                $eventStartDate = Carbon::parse($event->start_date)->startOfDay();
                $eventEndDate = Carbon::parse($event->end_date)->startOfDay();

                if ($attendanceDate->lt($eventStartDate) || $attendanceDate->gt($eventEndDate)) {
                    $validator->errors()->add('attendance_date', 'Attendance date must fall within the selected event date range.');
                }
            }
        });

        return $validator->validate();
    }

    protected function sessionOpeningDateTime(AttendanceSession $session): Carbon
    {
        $event = $session->event;

        return Carbon::parse(
            trim(($session->attendance_date ?? $event?->start_date ?? now()->toDateString()) . ' ' . ($session->time_in_start ?? $event?->start_time ?? '00:00')),
            'Asia/Manila'
        );
    }

    protected function sessionClosingDateTime(AttendanceSession $session): Carbon
    {
        $event = $session->event;
        $closingDate = $session->attendance_date ?? $event?->start_date ?? now()->toDateString();
        $closingTime = $session->time_out_end
            ?? $event?->end_time
            ?? '23:59';

        return Carbon::parse(
            trim($closingDate . ' ' . $closingTime),
            'Asia/Manila'
        );
    }

    protected function sessionAvailabilityState(AttendanceSession $session): string
    {
        $now = Carbon::now('Asia/Manila');

        if ($now->lt($this->sessionOpeningDateTime($session))) {
            return 'upcoming';
        }

        if ($now->gt($this->sessionClosingDateTime($session))) {
            return 'closed';
        }

        return 'open';
    }

    protected function attendanceErrorMessage(Exception $e, string $action): string
    {
        if ($e instanceof ModelNotFoundException) {
            return 'The selected record could not be found. Refresh the page and try again.';
        }

        if ($e instanceof QueryException) {
            return match ($action) {
                'manual' => 'That member already has attendance recorded for this session. Search for another member or review the existing record.',
                default => 'That attendance record conflicts with existing data. Refresh the page and try again.',
            };
        }

        return match ($action) {
            'session' => 'Could not create the attendance session. Check the event, date, and time fields, then try again.',
            'session_update' => 'Could not update the attendance session. Review the session name and time range, then try again.',
            'session_delete' => 'Could not delete the attendance session. Remove related attendance records first or refresh the page and try again.',
            'manual' => 'Could not add attendance for that member. Make sure the member and session are valid, then try again.',
            'approve' => 'Could not approve this attendance. Refresh the list and try again.',
            'reject' => 'Could not reject this attendance. Refresh the list and try again.',
            'remove' => 'Could not remove this attendance record. Refresh the list and try again.',
            default => 'Could not save attendance right now. Please try again.',
        };
    }

    private function filteredAttendanceSessions(Request $request)
    {
        return AttendanceSession::with(['event.type'])
            ->withCount([
                'attendances as approved_attendance_count' => function ($query) {
                    $query->where('status', 'Present');
                },
                'attendances as pending_attendance_count' => function ($query) {
                    $query->where('status', 'Pending');
                },
            ])
            ->when(trim((string) $request->query('attendance_search', '')) !== '', function ($query) use ($request) {
                $search = trim((string) $request->query('attendance_search'));

                $query->where(function ($query) use ($search) {
                    $query->where('attendance_name', 'like', "%{$search}%")
                        ->orWhereDate('attendance_date', $search)
                        ->orWhereHas('event', function ($query) use ($search) {
                            $query->where('event_name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('event.type', function ($query) use ($search) {
                            $query->where('type_name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->query('event_id'), function ($query, $eventId) {
                $query->where('event_id', $eventId);
            })
            ->when($request->query('type_name'), function ($query, $typeName) {
                $query->whereHas('event.type', function ($query) use ($typeName) {
                    $query->where('type_name', $typeName);
                });
            })
            ->when($request->query('attendance_date'), function ($query, $date) {
                $query->whereDate('attendance_date', $date);
            });
    }

    public function attendance(Request $request)
    {
        $events = Event::with('type')
            ->orderBy('start_date', 'desc')
            ->get();

        $attendanceSessions = $this->filteredAttendanceSessions($request)
            ->latest()
            ->paginate(4, ['*'], 'sessions_page')
            ->withQueryString();

        $attendanceTypes = AttendanceSession::with('event.type')
            ->get()
            ->pluck('event.type.type_name')
            ->filter()
            ->unique()
            ->sort()
            ->values();

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

            if ($isMarkingAttendance && $this->sessionAvailabilityState($selectedSession) !== 'open') {
                $message = $this->sessionAvailabilityState($selectedSession) === 'closed'
                    ? 'This attendance session has already ended.'
                    : 'This attendance session is not open yet. You can start marking attendance once the event begins.';

                return redirect()
                    ->route('attendance', ['attendance_session_id' => $selectedSession->attendance_session_id])
                    ->with('error', $message);
            }

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

            $availableMembers = Members::where('is_archived', false)
                ->whereNotIn('member_id', $alreadyAddedMemberIds)
                ->get();
        }

        $totalApproved = $approvedAttendances->count();
        $totalPending = $pendingAttendances->count();
        $totalRecords = $totalApproved + $totalPending;

        return view('attendance', compact(
            'events',
            'attendanceSessions',
            'attendanceTypes',
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
            $validated = $this->validateSessionData($request, true);
            $request->validate([
                'event_id' => 'required|exists:events,event_id',
            ]);

            $event = Event::findOrFail($request->event_id);

            $session = AttendanceSession::create([
                'event_id' => $event->event_id,
                'admin_id' => Auth::id(),
                'attendance_name' => $validated['attendance_name'],
                'attendance_date' => $validated['attendance_date'],
                'time_in_start' => $validated['time_in_start'] ?? null,
                'time_out_end' => $validated['time_out_end'] ?? null,
            ]);

            return redirect()
                ->route('attendance', ['attendance_session_id' => $session->attendance_session_id])
                ->with('success', 'Attendance created successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->attendanceErrorMessage($e, 'session'));
        }
    }

    public function updateSession(Request $request, $id)
    {
        try {
            $session = AttendanceSession::with('event')->findOrFail($id);
            $request->merge(['event_id' => $session->event_id]);
            $validated = $this->validateSessionData($request);

            $session->update([
                'attendance_name' => $validated['attendance_name'],
                'attendance_date' => $validated['attendance_date'],
                'time_in_start' => $validated['time_in_start'] ?? null,
                'time_out_end' => $validated['time_out_end'] ?? null,
            ]);

            return redirect()->route('attendance')->with('success', 'Attendance session updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please fix the highlighted attendance session details and try again.');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->attendanceErrorMessage($e, 'session_update'));
        }
    }

    public function destroySession($id)
    {
        try {
            $session = AttendanceSession::withCount('attendances')->findOrFail($id);

            if ($session->attendances_count > 0) {
                return redirect()->back()->with('error', 'This attendance session already has attendance records. Remove those records first before deleting the session.');
            }

            $session->delete();

            return redirect()->route('attendance')->with('success', 'Attendance session deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->attendanceErrorMessage($e, 'session_delete'));
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
        $member = Members::where('member_id', $validated['member_id'])
            ->where('is_archived', false)
            ->firstOrFail();

        $availability = $this->sessionAvailabilityState($session->loadMissing('event'));

        if ($availability !== 'open') {
            return redirect()->back()->with('error', $availability === 'closed'
                ? 'This attendance session has already ended. Attendance can no longer be added.'
                : 'This attendance session is not open yet. You can add attendance once the event begins.');
        }

        Attendance::updateOrCreate(
            [
                'attendance_session_id' => $session->attendance_session_id,
                'member_id' => $member->member_id,
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
                ->with('error', $this->attendanceErrorMessage($e, 'manual'));
        }
    }

    public function approve($id)
    {
        try{
        $attendance = Attendance::findOrFail($id);
        $session = $attendance->attendanceSession()->with('event')->first();

        if ($session) {
            $availability = $this->sessionAvailabilityState($session);

            if ($availability !== 'open') {
                return redirect()->back()->with('error', $availability === 'closed'
                    ? 'This attendance session has already ended. Approval is no longer available here.'
                    : 'This attendance session is not open yet. Approval is available once the event begins.');
            }
        }

        $attendance->update([
            'status' => 'Present',
            'admin_id' => Auth::id(),
            'attended_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Attendance approved.');
        }catch(Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->attendanceErrorMessage($e, 'approve'));
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
            ->with('error', $this->attendanceErrorMessage($e, 'reject'));
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
            ->with('error', $this->attendanceErrorMessage($e, 'remove'));
    }
    }
}
