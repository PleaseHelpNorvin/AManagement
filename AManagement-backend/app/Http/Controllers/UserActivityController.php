<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UserActivityController extends ApiController
{
    public function updateActivity(Request $request)
    {
        Log::info('updateactivity reached');
        $user = Auth::user();
        if ($user) {
            $now = Carbon::now('Asia/Manila');
            $user->update(['last_active_at' => $now]);

            // Log::info('User activity updated.', [
            //     'user_id' => $user->id,
            //     'last_active_at' => $now->toDateTimeString()
            // ]);

            return response()->json(['message' => 'User activity updated successfully.', 'last_active_at' => $now]);
        }

        Log::warning('User activity update failed - user not authenticated.');

        return response()->json(['error' => 'User not authenticated.'], 401);
    }

    public function getActivityInfo()
    {
        $user = Auth::user();
        if ($user) {
            Log::info('User activity information retrieved.', [
                'user_id' => $user->id,
                'last_active_at' => $user->last_active_at
            ]);

            return response()->json([
                'last_active_at' => $user->last_active_at,
                'message' => 'Activity information retrieved successfully.'
            ]);
            // Log::info('Activity information retrieved succesfully');
        }

        Log::warning('Activity information retrieval failed - user not authenticated.');

        return response()->json(['error' => 'User not authenticated.'], 401);
    }
}
