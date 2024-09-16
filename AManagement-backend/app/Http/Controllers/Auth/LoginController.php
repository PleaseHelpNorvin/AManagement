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

        
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Generate a token for the user
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            // Determine role and respond accordingly
            if ($user->isAdmin()) {
                return $this->successResponse([
                    'token' => $token,
                    'role' => 'admin'
                ], 'Admin logged in successfully');
            }

            if ($user->isUser()) {
                return $this->successResponse([
                    'token' => $token,
                    'role' => 'user'
                ], 'User logged in successfully');
            }
            return $this->forbiddenResponse(null, 'Unauthorized');
        }

        // Return error if authentication fails
        return $this->errorResponse(null, 'Invalid credentials');
    }
}
