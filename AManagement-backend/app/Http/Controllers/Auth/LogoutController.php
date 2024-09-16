<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class LogoutController extends ApiController
{
    //
    public function logout(Request $request)
    {
        try {
            // Revoke all tokens for the authenticated user
            $user = Auth::user();
            if ($user) {
                $user->tokens()->delete(); // Ensure the User model has the tokens() method
                return $this->successResponse(null, 'Successfully logged out.');
            } else {
                return $this->errorResponse(null, 'User not authenticated.', 401);
            }
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Failed to log out. ' . $e->getMessage(), 500);
        }
    }
}
