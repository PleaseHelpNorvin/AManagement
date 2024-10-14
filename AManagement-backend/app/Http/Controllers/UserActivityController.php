<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckUserActivity;
use Carbon\Carbon;

class UserActivityController extends ApiController
{
    protected $checkUserActivityMiddleware;
    
    public function __construct(CheckUserActivity $checkUserActivityMiddleware) {
        $this->checkUserActivityMiddleware = $checkUserActivityMiddleware;
    }
    //
    public function getActivityInfo(Request $request) {
         // Call the checkUserActivity method to handle inactivity check
        //  $logoutResponse = $this->checkUserActivityMiddleware->checkUserActivity($request);
        
         // If the user is logged out, return the response
        //  if ($logoutResponse) {
        //      return $logoutResponse; 
        //  }
        // if ($user) {
        //     return response()->json([
        //         'last_active_at' => $user->last_active_at,
        //         'message' => 'User activity retrieved successfully.'
        //     ]);
        // }
 
         // If the user is active, return the activity info
         $user = Auth::user();

        if ($user) {
            return response()->json([
                'last_active_at' => $user->last_active_at,
                'message' => 'User activity retrieved successfully.'
            ]);
        }

        return response()->json([
            'error' => 'User not authenticated.'
        ], 401);
    }
}
