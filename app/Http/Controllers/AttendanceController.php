<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class AttendanceController extends Controller
{
    public function attendance(Request $request)
    {
        $events = Event::orderBy('start_date', 'desc')->get();

        $selectedEventId = $request->event_id ?? $events->first()?->event_id;

        $selectedEvent = null;
        $approvedAttendances = collect();
        $pendingAttendances = collect();
        $availableMembers = collect();

        if ($selectedEventId) {
            $selectedEvent = Event::find($selectedEventId);

            $approvedAttendances = Attendance::with('member')
                ->where('event_id', $selectedEventId)
                ->where('status', 'Present')
                ->latest('attended_at')
                ->get();

            $pendingAttendances = Attendance::with('member')
                ->where('event_id', $selectedEventId)
                ->where('status', 'Pending')
                ->latest('attended_at')
                ->get();

            $alreadyAddedMemberIds = Attendance::where('event_id', $selectedEventId)
                ->pluck('member_id');

            $availableMembers = Members::whereNotIn('member_id', $alreadyAddedMemberIds)->get();
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
        try{
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