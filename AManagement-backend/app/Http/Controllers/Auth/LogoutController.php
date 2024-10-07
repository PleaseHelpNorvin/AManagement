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
           if(!Auth::check()){
            return $this->errorResponse(null, 'User not authenticated', 401);
           }

            $user = Auth::user();
            $now = Carbon::now();

            $user->update([
                'is_logged_in' => false,
                'last_active_at' => $now,
                
            ]);

            $request->user()->currentAccessToken()->delete();
            // $request->user()->revokeAdminToken();

            return $this->successResponse(
                $user->is_logged_in,
                'Successfully logged out.'
            );
                
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Failed to log out. ' . $e->getMessage(), 500);
        }
    }
}
