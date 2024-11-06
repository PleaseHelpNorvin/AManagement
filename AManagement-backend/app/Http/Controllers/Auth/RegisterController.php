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
    public function tenantRegister(Request $request)
    {
        \Log::info('Registering user with data:', $request->all());

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'name' => 'nullable|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:15',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            \Log::error('Validation failed', $validator->errors()->toArray());

            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        // Create a new user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 0, // Set role (0 for user, 1 for admin, etc.)
        ]);

        // Create associated client information if provided
        ClientInformation::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
        ]);

        // Mark user as logged in and create a token
        $user->is_logged_in = true;
        $user->save();
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            // 'user_id' => $user->id,
            'user_info' => $user,
        ], 'Registration and authentication successful');
    }

    public function updateClientInformation(Request $request, $userId)
    {
        // Check if the token is provided in the Authorization header
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        // Get the authenticated user
        $authenticatedUser = auth()->user();

        // Ensure the authenticated user is the same as the user attempting to update the information
        if ($authenticatedUser->id !== (int)$userId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:15',
        ]);

        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find the client information associated with the user
        $clientInfo = ClientInformation::where('user_id', $userId)->first();

        if (!$clientInfo) {
            return response()->json(['message' => 'Client information not found'], 404);
        }

        // Update client information with the request data
        $clientInfo->update($request->only([
            'name', 'middlename', 'lastname', 'gender', 'address', 'contact_number'
        ]));

        // Retrieve the updated client information
        $updatedClientInfo = ClientInformation::where('user_id', $userId)->first();

        // Return response with updated information and token
        return response()->json([
            'message' => 'Client information updated successfully',
            'token' => $token, // Returning the token back in the response
            'client_info' => $updatedClientInfo,
            
        ]);
    }
}
