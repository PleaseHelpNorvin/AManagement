<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UserActivityController extends ApiController
{
    /**
     * Update the user's activity timestamp.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateActivity(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $now = Carbon::now('Asia/Manila');
            $user->update(['last_active_at' => $now]);

            // Log the activity update
            Log::info('User activity updated.', [   
                'user_id' => $user->id,
                'last_active_at' => $now->toDateTimeString()
            ]);

            return response()->json(['message' => 'User activity updated successfully.', 'last_active_at' => $now]);
        }

        // Log the error for unauthenticated user
        Log::warning('User activity update failed - user not authenticated.');

        return response()->json(['error' => 'User not authenticated.'], 401);
    }

    /**
     * Get information about the user's last activity.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActivityInfo()
    {
        $user = Auth::user();
        if ($user) {
            // Log the activity information retrieval
            Log::info('User activity information retrieved.', [
                'user_id' => $user->id,
                'last_active_at' => $user->last_active_at
            ]);

            return response()->json([
                'last_active_at' => $user->last_active_at,
                'message' => 'Activity information retrieved successfully.'
            ]);
        }

        // Log the error for unauthenticated user
        Log::warning('Activity information retrieval failed - user not authenticated.');

        return response()->json(['error' => 'User not authenticated.'], 401);
    }
}
