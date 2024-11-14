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
        // Use SESSION_LIFETIME from .env
        $allowedInactiveTime = (int) env('SESSION_LIFETIME', 1) * 60; // Convert to seconds
        $lastActivityTime = session('last_activity_time', Carbon::now('Asia/Manila'));
        
        Log::info('Last Activity Time:', ['time' => $lastActivityTime]);

        if (Auth::check()) {
            $user = $request->user();
            $currentTime = Carbon::now('Asia/Manila');
            $inactiveDuration = $currentTime->diffInSeconds($lastActivityTime);
            
            Log::info('Inactive Duration:', ['duration' => $inactiveDuration]);
            
            // Check against SESSION_LIFETIME
            if ($inactiveDuration >= $allowedInactiveTime) {
                Log::info('User logged out due to inactivity:', ['user_id' => Auth::id()]);
                session()->flush();
                return redirect('/login')->with('message', 'You have been logged out due to inactivity.');
            }

            session(['last_activity_time' => $currentTime]);
            Log::info('Updated Last Activity Time:', ['time' => $currentTime]);
        }

        return $next($request);
    }
}
