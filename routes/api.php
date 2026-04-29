<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\ReportController;

Route::post('attendance/scan', [AttendanceController::class, 'scanAttendance'])
    ->middleware('throttle:scan-attendance');

Route::middleware(['web', 'auth', 'role:super_admin'])->name('api.')->group(function () {
    Route::apiResource('members', MemberController::class);
    Route::get('reports', [ReportController::class, 'index']);
});

Route::middleware(['web', 'auth', 'role:super_admin,admin'])->name('api.')->group(function () {
    Route::apiResource('events', EventController::class);
    Route::apiResource('attendance', AttendanceController::class)->only(['index', 'store', 'show']);
});
