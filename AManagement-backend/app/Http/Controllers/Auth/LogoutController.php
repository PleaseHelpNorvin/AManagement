<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;



class LogoutController extends ApiController
{
    //
    public function logout(Request $request)
    {
        try {
            // Revoke all tokens for the authenticated user
            $user = Auth::user();
            if ($user) {
                $now = Carbon::now();

                $user->update(['is_logged_in' => false]);
                $user->update(['last_active_at' => $now]);
                
                $request->user()->currentAccessToken()->delete();
                // $user->tokens()->delete(); // Ensure the User model has the tokens() method
                return $this->successResponse(
                    $user->is_logged_in,
                    'Successfully logged out.'
                );
            } else {
                return $this->errorResponse(null, 'User not authenticated.', 401);
            }
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Failed to log out. ' . $e->getMessage(), 500);
        }
    }
}
