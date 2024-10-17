<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Auth\LogoutController;

class UserActivityMiddleware
{
    protected $logoutController;

    public function __construct(LogoutController $logoutController)
    {
        $this->logoutController = $logoutController;
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $now = Carbon::now('Asia/Manila');
            $lastActiveAt = Carbon::parse($user->last_active_at)->setTimezone('Asia/Manila');
            $inactiveDuration = $lastActiveAt->diffInMinutes($now);

            $allowedInactiveTime = 1; // In minutes

            if ($inactiveDuration > $allowedInactiveTime) {
                Log::info('User ID: ' . $user->id . ' has been logged out due to inactivity at ' . $now->format('g:i A'));

                // Call the LogoutController's logout method
                return app(LogoutController::class)->logout($request);
            } else {
                // Update last active time
                $user->update(['last_active_at' => $now]);
                Log::info('User activity updated.');
            }
        }

        return $next($request);
    }
}
