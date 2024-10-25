<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\ApiController;
// use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Add this import

// use O;;

class LoginController extends ApiController
{
    //
    public function login(Request $request)
    {
        // Validate incoming request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'rememberMe' => 'required'
        ]);

        // dd($credentials);

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
                    // Log::info('User ID: ' . $user->id . ' has logged in.');
                    Log::info('User ID: ' . $user->id . ' has logged in successfully.');


                    if ($request->filled('rememberMe')) {
                        $rememberToken = Str::random(60);
                        $user->update(['remember_token' => $rememberToken]);
                    }
                        
                    Session::put('user_id', $user->id);
                
                    Session::put('role', $user->isAdmin() ? 'admin' : 'user');
        
                    $user->update([
                        'is_logged_in' => true,
                        // 'remember_token' => $rememberToken
                    ]);
                    // $user->update('remember_token'=> $random);
        
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
            // return $this->InternalServerErrorResponse(
            //     null,
            //     'An Internal Sever error occurred. Please try again later',
            //     500
            // );
        }
    }

    public function tenantLogin(Request $request)
{
    // Validate incoming request
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    try {
        // Retrieve the user
        $existingUser = User::where('email', $request->email)->first();

        // Check if user exists
        if (!$existingUser) {
            return $this->errorResponse(
                null, 
                'User not found',
                404
            );
        }

        // Check if the user is a tenant
        if (!$existingUser->isUser()) {
            return $this->forbiddenResponse(
                null,
                'Access denied. Only for tenants.',
                403
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

        // Attempt login
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Log::info('Tenant User ID: ' . $user->id . ' has logged in successfully.');

            // Mark the user as logged in
            $user->update(['is_logged_in' => true]);

            // Generate a token
            $token = $user->createToken('Tenant Access Token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'role' => 'tenant',
                'is_logged_in' => $user->is_logged_in,
            ], 200);
        }

        return $this->errorResponse(
            null, 
            'Invalid credentials',
            401
        );
    } catch (\Throwable $th) {
        // Log::error('Tenant login error: ' . $th->getMessage());
        // return $this->InternalServerErrorResponse(
        //     null,
        //     'An internal server error occurred. Please try again later.',
        //     500
        // );
    }
}

}
