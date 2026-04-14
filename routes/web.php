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

Route::get('/homepage', [HomeController::class, 'homepage'])->name('homepage');
Route::get('/homeevent', [HomeEventController::class, 'homeevent'])->name('homeevent');

Route::get('/login', [UserController::class, 'showlogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('auth.login.submit');
Route::post('/logout', [UserController::class, 'logout'])->name('auth.logout');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');
    
Route::get('/member', [MemberController::class, 'member'])->middleware('auth')->name('member');
Route::get('/event', [EventController::class, 'event'])->middleware('auth')->name('event');
Route::get('/attendance', [AttendanceController::class, 'attendance'])->middleware('auth')->name('attendance');
Route::get('/report', [ReportController::class, 'report'])->middleware('auth')->name('report');

Route::get('/', function () {
    return view('welcome');
});