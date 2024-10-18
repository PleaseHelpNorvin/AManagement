<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import Log facade
use Carbon\Carbon;

class UserActivityMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Get the allowed inactive time from environment or default to 30 minutes
        $allowedInactiveTime = (int) env('SESSION_TIMEOUT', 30) * 60; // Convert minutes to seconds

        // Get the user's last activity time from the session or default to now
        $lastActivityTime = session('last_activity_time', Carbon::now('Asia/Manila'));

        // Log the last activity time for debugging
        Log::info('Last Activity Time:', ['time' => $lastActivityTime]);

        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the current time
            $currentTime = Carbon::now('Asia/Manila');

            // Calculate the time difference since the last activity
            $inactiveDuration = $currentTime->diffInSeconds($lastActivityTime);

            // Log the inactive duration for debugging
            Log::info('Inactive Duration:', ['duration' => $inactiveDuration]);

            // Check if the user has been inactive for too long
            if ($inactiveDuration > $allowedInactiveTime) {
                // Log out the user
                Log::info('User logged out due to inactivity:', ['user_id' => Auth::id()]);

                // Clear session data
                session()->flush();

                // Optionally redirect to login page
                return redirect('/login')->with('message', 'You have been logged out due to inactivity.');
            }

            // Update the last activity time to the current time
            session(['last_activity_time' => $currentTime]);
            Log::info('Updated Last Activity Time:', ['time' => $currentTime]);
        }

        return $next($request);
    }
}
