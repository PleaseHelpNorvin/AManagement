<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;




class LogoutController extends ApiController
{
    //
    public function logout(Request $request)
    {
        try {
            // Revoke all tokens for the authenticated user
           if(!Auth::check()){
                Log::warning('Logout attempt by unauthenticated user.', [
                'ip_address' => $request->ip(),
                'timestamp' => Carbon::now()
            ]);

            return $this->errorResponse(null, 'User not authenticated', 401);
           }

            $user = Auth::user();
            $now = Carbon::now();
            $token = $request->user()->currentAccessToken()->get();
            Log::info('user UD: ' . $user->id . ' successfuly log out');
            Log::info('logged out with token'. $token);

            $user->update([
                'is_logged_in' => false,
                'last_active_at' => $now,
                'remember_token' => null,
                
            ]);

            $request->user()->currentAccessToken()->delete();
            // $request->user()->revokeAdminToken();

            return $this->successResponse(
                null,
                // $user->is_logged_in,
                'Successfully logged out.'
            );
                
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Failed to log out. ' . $e->getMessage(), 500);
        }
    }
}
