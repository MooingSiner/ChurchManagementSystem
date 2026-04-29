<?php

namespace App\Providers;

use App\Models\Attendance;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('scan-attendance', function (Request $request) {
            return [
                Limit::perMinute(30)->by($request->ip()),
            ];
        });

        View::composer([
            'dashboard',
            'members',
            'events',
            'attendance',
            'report',
        ], function ($view) {
            $view->with('navigationBadges', [
                'attendance_pending' => Attendance::where('status', 'Pending')->count(),
            ]);

            $view->with('currentRoleLabel', Auth::user()?->role_label);
        });
    }
}
