<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Members;
use App\Models\Event;
use App\Models\Attendance;

class ReportController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_members' => Members::count(),
                'total_events' => Event::count(),
                'total_attendances' => Attendance::count(),
            ],
        ]);
    }
}