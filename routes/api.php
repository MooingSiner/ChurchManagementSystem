<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\ReportController;

Route::name('api.')->group(function () {
    Route::apiResource('members', \App\Http\Controllers\Api\MemberController::class);
});
Route::name('api.')->group(function () {
    Route::apiResource('events', \App\Http\Controllers\Api\EventController::class);
});
Route::name('api.')->group(function () {
    Route::apiResource('attendance', \App\Http\Controllers\Api\AttendanceController::class)->only(['index', 'store', 'show']);
});
Route::name('api.')->group(function () {
    Route::get('reports', [ReportController::class, 'index']);
});