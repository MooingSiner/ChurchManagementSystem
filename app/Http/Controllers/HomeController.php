<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Members;
use App\Models\Attendance;
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

    $attendanceMemberIds = Attendance::select('event_id', 'member_id')->get();

    return view('home', compact('events', 'members', 'attendanceMemberIds'));
}
    
    public function submitAttendance(Request $request)
    {
        try{
        $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'member_id' => 'required|exists:members,member_id',
        ]);

        Attendance::create([
            'event_id' => $request->event_id,
            'member_id' => $request->member_id,
            'admin_id' => 1,
            'attended_at' => now(),
            'status' => 'Pending',
        ]);

        return redirect()->route('home')
            ->with('success', 'Attendance submitted! Waiting for admin approval.');
    }
    catch(Exception $e){
        return redirect()->route('home')
            ->with('error', 'Attendance already submitted for this event.');
    }
    }
}