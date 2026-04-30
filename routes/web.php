<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Web Routes
Route::redirect('/', '/home')->name('root');
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [AttendanceController::class, 'attendance'])->name('attendance');

    // Event Routes
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::put('/events/{id}/finish', [EventController::class, 'finish'])->name('events.finish');

    // Attendance Routes
    Route::post('/attendance/sessions', [AttendanceController::class, 'storeSession'])->name('attendance.sessions.store');
    Route::put('/attendance/sessions/{id}', [AttendanceController::class, 'updateSession'])->name('attendance.sessions.update');
    Route::delete('/attendance/sessions/{id}', [AttendanceController::class, 'destroySession'])->name('attendance.sessions.destroy');
    Route::post('/attendance/manual', [AttendanceController::class, 'addManual'])->name('attendance.manual');
    Route::put('/attendance/{id}/approve', [AttendanceController::class, 'approve'])->name('attendance.approve');
    Route::delete('/attendance/{id}/reject', [AttendanceController::class, 'reject'])->name('attendance.reject');
    Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');

    Route::middleware('role:super_admin')->group(function () {
        Route::get('/report', [ReportController::class, 'report'])->name('report');
    });

    Route::middleware('role:super_admin,admin')->group(function () {
        Route::get('/members', [MemberController::class, 'index'])->name('members.index');
        Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
    });

    Route::middleware('role:super_admin')->group(function () {
        Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
        Route::post('/members', [MemberController::class, 'store'])->name('members.store');
        Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('members.edit');
        Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');
        Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');
        Route::put('/members/{id}/restore', [MemberController::class, 'restore'])->name('members.restore');
    });
});

Route::post('/home/attendance-submit', [HomeController::class, 'submitAttendance'])->name('home.attendance.submit');
