<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\ApiController;
// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        
        try {

            $existingUser = User::where('email', $request->email)->first();
            
            if ($existingUser) {

                if($existingUser->isUser()) {
                    return $this->forbiddenResponse(
                        null,
                        'Access denied. only for admin'
                    );
                }

                // Check if the user is already logged in
                if ($existingUser->is_logged_in) {
                    return $this->forbiddenResponse(
                        null,
                        'User is already logged in.',
                        403
                    );
                }
                if(!$existingUser) {
                    return $this->errorResponse([
                        null,
                        'user Not found',
                        401
                    ]);
                }

                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                    // dd($user);
                    Session::put('user_id', $user->id);
                
                    Session::put('role', $user->isAdmin() ? 'admin' : 'user');
        
                    $user->update(['is_logged_in' => true]);
        
                    if ($user->isAdmin()) {
                        $user->revokeAdminTokenById($user->id);
                    }

                    $token = $user->createToken('Personal Access Token')->plainTextToken;
                    // dd($user);

                    return response()->json([
                        'token' => $token,
                        'role' => $user->isAdmin() ? 'admin' : 'user',
                        'is_logged_in' => $user->is_logged_in,
                    ], 200);
                }
            }
            return $this->errorResponse(
                null, 
                'Invalid credentials',
                401
            );
        } catch (\Throwable $th) {
            //throw $th;
            return $this->InternalServerErrorResponse(
                null,
                'An Internal Sever error occurred. Please try again later',
                500
            );
        }
    }
}
