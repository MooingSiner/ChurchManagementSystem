<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeEventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Web Routes
Route::get('/homepage', [HomeController::class, 'homepage'])->name('homepage');
Route::get('/homeevent', [HomeEventController::class, 'homeevent'])->name('homeevent');
Route::get('/login', [UserController::class, 'showlogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('auth.login.submit');
Route::post('/logout', [UserController::class, 'logout'])->name('auth.logout');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware('auth')->name('dashboard');   
Route::get('/attendance', [AttendanceController::class, 'attendance'])->middleware('auth')->name('attendance');
Route::get('/report', [ReportController::class, 'report'])->middleware('auth')->name('report');

Route::get('/', function () {
    return view('homepage');
});

// Member Routes
Route::get('/members', [MemberController::class, 'index'])->middleware('auth')->name('members.index');
Route::get('/members/create', [MemberController::class, 'create'])->middleware('auth')->name('members.create');
Route::post('/members', [MemberController::class, 'store'])->middleware('auth')->name('members.store');
Route::get('/members/{id}', [MemberController::class, 'show'])->middleware('auth')->name('members.show');
Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->middleware('auth')->name('members.edit');
Route::put('/members/{id}', [MemberController::class, 'update'])->middleware('auth')->name('members.update');
Route::delete('/members/{id}', [MemberController::class, 'destroy'])->middleware('auth')->name('members.destroy');

// Event Routes
Route::get('/events', [EventController::class, 'index'])->middleware('auth')->name('events.index');
Route::get('/events/create', [EventController::class, 'create'])->middleware('auth')->name('events.create');
Route::post('/events', [EventController::class, 'store'])->middleware('auth')->name('events.store');
Route::get('/events/{id}', [EventController::class, 'show'])->middleware('auth')->name('events.show');
Route::get('/events/{id}/edit', [EventController::class, 'edit'])->middleware('auth')->name('events.edit');
Route::put('/events/{id}', [EventController::class, 'update'])->middleware('auth')->name('events.update');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth')->name('events.destroy');
Route::put('/events/{id}/finish', [EventController::class, 'finish'])->name('events.finish');

//Attendance Routes
Route::post('/attendance/manual', [AttendanceController::class, 'addManual'])->middleware('auth')->name('attendance.manual');
Route::put('/attendance/{id}/approve', [AttendanceController::class, 'approve'])->middleware('auth')->name('attendance.approve');
Route::delete('/attendance/{id}/reject', [AttendanceController::class, 'reject'])->middleware('auth')->name('attendance.reject');
Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy'])->middleware('auth')->name('attendance.destroy');
