<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Auth\LogoutController;

class CheckUserActivity
{
    protected $logoutController;

    public function __construct(LogoutController $logoutController)
    {
        $this->logoutController = $logoutController;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $logoutResponse = $this->checkUserActivity($request);

        if ($logoutResponse) {
            return $logoutResponse; // Return logout response if needed
        }

        return $next($request);
    }

    public function checkuseractivity(Request $request) : ?Response {
        $user = Auth::user();
        if ($user) {
            $now = Carbon::now('Asia/Manila');
            $lastActiveAt = Carbon::parse($user->last_active_at)->setTimezone('Asia/Manila');
            $inactiveDurationInSeconds  = $lastActiveAt->diffInSeconds($now); // Calculate inactivity duration in minutes
            $inactiveDuration = round($inactiveDurationInSeconds / 60, 2); // Rounded to 2 decimal places


            // Log the time in 12-hour format with AM/PM
            Log::info('User ID: ' . $user->id . ' last_active_at: ' . $lastActiveAt->format('g:i A'));
            Log::info('User ID: ' . $user->id . ' inactive duration: ' . $inactiveDuration . ' MINUTES');

            // Set the allowed inactive time in minutes
            //CHANGE VALUE IN MINUTES
            $allowedInactiveTime = 1; // Change this value to your preference
            

            // Check if the user has been inactive for too long
            if ($inactiveDuration > $allowedInactiveTime) {
                Log::info('User ID: ' . $user->id . ' has been logged out due to inactivity at ' . $now->format('g:i A'));
                // Log::info('you inactive for: ' . $. )
                Log::info('Calling logout method for User ID: ' . $user->id);

                // Call the logout method from LogoutController
                return $this->logoutController->logout($request);
            } else {
                // Log::info('User ID: ' . $user->id . ' is active. resetting last active time.');
                Log::info('User ID: ' . $user->id . ' is active. resetting last active time at ' . $now->format('g:i A'));

                // Reset the last active time to now
                $user->update(['last_active_at' => $now]);
            }
        }
        return null;
    }
}
