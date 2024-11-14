<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\ClientInformation;

use App\Http\Requests\TenantLoginRequest;

use App\Http\Controllers\ApiController;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Add this import

// use O;;

class LoginController extends ApiController
{
    //
    public function adminlogin(Request $request)
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
                    \Log::info("User logged in successfully with token ['token' => $token]");
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

    public function tenantLogin(TenantLoginRequest $request)
    {
        try {
            $existingUser = User::where('username', $request->username)->first();

            if (!$existingUser) {
                return $this->errorResponse(
                    null, 
                    'User not found',
                    404
                );
            }

            if (!$existingUser->isUser()) {
                return $this->forbiddenResponse(
                    null,
                    'Access denied. Only for tenants.',
                    403
                );
            }

            if ($existingUser->is_logged_in) {
                return $this->forbiddenResponse(
                    null,
                    'User is already logged in.',
                    403
                );
            }

            if (Auth::attempt($request->only('username', 'password'))) {
                $user = Auth::user();
                Log::info('Tenant User ID: ' . $user->id . ' has logged in successfully.');

                $user->update([
                'is_logged_in' => true
                // 'last_used_at' => now()
            ]);

                $token = $user->createToken('Tenant Access Token')->plainTextToken;
                \Log::info("User logged in successfully with token ['token' => $token]");
                $clientInfo = $user->clientInformation;
                $userInfo = User::find($user->id);

                return $this->successResponse([
                    'token' => $token,
                    'role' => 'tenant',
                    'user_info' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'is_logged_in' => $user->is_logged_in,
                        'updated_at' => $user->updated_at,
                        'created_at' => $user->created_at,
                    ],
                    'client_info' => [
                        'id' => $clientInfo->id,
                        'user_id' => $clientInfo->user_id,
                        'name' => $clientInfo->name,
                        'middlename' => $clientInfo->middlename,
                        'lastname' => $clientInfo->lastname,
                        'gender' => $clientInfo->gender,
                        'address' => $clientInfo->address,
                        'contact_number' => $clientInfo->contact_number,
                        'updated_at' => $clientInfo->updated_at,
                        'created_at' => $clientInfo->created_at,
                    ]
                ], 'tenant logged in successfully');
            }

            return $this->errorResponse(
                null, 
                'Invalid credentials',
                401
            );
        } catch (\Throwable $th) {
            Log::error('Tenant login error: ' . $th->getMessage());
            return $this->InternalServerErrorResponse(
                null,
                'An internal server error occurred. Please try again later.',
                500
            );
        }
    }

}
