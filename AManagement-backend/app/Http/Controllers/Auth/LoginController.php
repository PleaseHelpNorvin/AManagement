<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\ApiController;
// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiController
{
    //
    public function login(Request $request)
    {
        // Validate incoming request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $existingUser = User::where('email', $request->email)->first();
        
        if ($existingUser) {

            // Check if the user is already logged in
            if ($existingUser->is_logged_in) {
                return response()->json(['message' => 'User is already logged in.'], 403);
            }

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
    
                $user->update(['is_logged_in' => true]);
    
                if ($user->isAdmin()) {
                    User::all()->each(function ($admin) {
                        $admin->revokeAdminTokens();
                    });
                }
    
                $user->revokeAdminTokens();
                $token = $user->createToken('Personal Access Token')->plainTextToken;
    
                return response()->json([
                    'token' => $token,
                    'role' => $user->isAdmin() ? 'admin' : 'user',
                    'is_logged_in' => $user->is_logged_in,
                ], 200);
            }
        }

        // Return error if authentication fails
        return $this->errorResponse(null, 'Invalid credentials');
    }
}
