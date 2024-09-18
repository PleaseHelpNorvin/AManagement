<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
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
            
            if ($existingUser->is_logged_in) {
                $existingUser->revokeAdminTokens();
                $existingUser->update(['is_logged_in' => false]);
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
                    'role' => $user->isAdmin() ? 'admin' : 'user'
                ], 200);
            }
        }

        // Return error if authentication fails
        return $this->errorResponse(null, 'Invalid credentials');
    }
}
