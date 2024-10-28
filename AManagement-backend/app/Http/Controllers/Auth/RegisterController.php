<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\ClientInformation;


class RegisterController extends ApiController
{
    //
    public function tenantRegister(Request $request)
    {
        \Log::info('Registering user with data:', $request->all());

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'nickname' => 'nullable|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'gcash_number' => 'nullable|string|max:20',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            \Log::error('Validation failed', $validator->errors()->toArray());

            // return $this->errorResponse('Validation error', $validator->errors(), 422);
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Ensure password is hashed
            'role' => 0, // Set role here as needed (0 for user, 1 for admin, etc.)
        ]);
    
        // Create associated client information if provided
        ClientInformation::create([
            'user_id' => $user->id, // Associate with the created user
            'nickname' => $request->nickname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'gcash_number' => $request->gcash_number,
        ]);
    
        // Generate a token for the new user
        $token = $user->createToken($user->role)->plainTextToken;
    
        // Return a successful response with the token
        return $this->successResponse(['token' => $token], 'Registration successful');

        if (!$user) {
            \Log::error('User creation failed');
            return $this->errorResponse('User creation failed', [], 500);
        }
    }
}
