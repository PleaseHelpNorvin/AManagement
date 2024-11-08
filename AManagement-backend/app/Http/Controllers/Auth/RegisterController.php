<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ClientInformation;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateClientInformationRequest;

class RegisterController extends ApiController
{
    public function tenantRegister(RegisterRequest $request)
    {
        \Log::info('Registering user with data:', $request->all());

        // Retrieve validated data
        $validatedData = $request->validated();

        $defaultName = 'John Doe';  // static default name
        $defaultMiddleName = 'N/A'; // static default middle name
        $defaultLastName = 'Doe';   // static default last name
        $defaultGender = 'Unknown'; // static default gender
        $defaultAddress = 'Unknown'; // static default address
        $defaultContactNumber = '0000000000'; // static default contact number

        // Ensure that missing nullable fields are safely handled
        $user = User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Use Hash::make for password hashing
            'name' => $validatedData['name'] ?? $defaultName,
            'middlename' => $validatedData['middlename'] ?? $defaultMiddleName,
            'lastname' => $validatedData['lastname'] ?? $defaultLastName,
            'gender' => $validatedData['gender'] ?? $defaultGender,
            'address' => $validatedData['address'] ?? $defaultAddress,
            'contact_number' => $validatedData['contact_number'] ?? $defaultContactNumber,
        ]);
        // Create associated client information
        $clientInfo = ClientInformation::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'] ?? $defaultName,
            'middlename' => $validatedData['middlename'] ?? $defaultMiddleName,
            'lastname' => $validatedData['lastname'] ?? $defaultLastName,
            'gender' => $validatedData['gender'] ?? $defaultGender,
            'address' => $validatedData['address'] ?? $defaultAddress,
            'contact_number' => $validatedData['contact_number'] ?? $defaultContactNumber,
        ]);
    
        // Mark user as logged in and create a token
        $user->is_logged_in = true;
        $user->save();
        $token = $user->createToken('Tenant Access Token')->plainTextToken;

        // Log the successful registration
        \Log::info('User registered successfully with token:', ['token' => $token]);

        // Return response with user data and token
        // return $this->successResponse([
        //     'token' => $token,
        //     'role' => 'tenant',
        //     'is_logged_in' => $user->is_logged_in,
        //     'user_info' => $user->toArray(),
        //     'client_info' => $clientInfo->toArray(),
        // ], 'Tenant created successfully');

        return $this->successResponse([
            'token' => $token,
            'role' => 'tenant',
            'is_logged_in' => $user->is_logged_in,
            'user_info' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'updated_at' => $user->updated_at,
                'created_at' => $user->created_at,
                'is_logged_in' => $user->is_logged_in
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
        ], 'Tenant created successfully');
    }

    public function updateClientInformation(UpdateClientInformationRequest $request, $userId)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return $this->errorResponse(null, 'Please login first', 401); // Respond with login prompt
        }

        // Get the authenticated user
        $authenticatedUser = auth()->user();

        // Ensure the authenticated user is the same as the user attempting to update the information
        if ($authenticatedUser->id !== (int)$userId) {
            return $this->forbiddenResponse(null, 'Unauthorized'); // Return Forbidden if users don't match
        }

        // Find the client information associated with the user
        $clientInfo = ClientInformation::where('user_id', $userId)->first();

        if (!$clientInfo) {
            return $this->errorResponse(null, 'Client information not found', 404); // Return error if client info doesn't exist
        }

        // Update client information with the request data
        $clientInfo->update($request->only([
            'name', 'middlename', 'lastname', 'gender', 'address', 'contact_number'
        ]));

        // Retrieve the updated client information
        $updatedClientInfo = ClientInformation::where('user_id', $userId)->first();
        $role = $authenticatedUser->role === 1 ? 'admin' : 'tenant'; 
        $islogin = $authenticatedUser->is_logged_in === 1;
        // $islogin = (bool) $authenticatedUser->is_logged_in;

        // Return response with updated information and token
        return $this->successResponse([
            'token' => $request->bearerToken(), // Returning the token back in the response
            'role' => $role,
            'is_logged_in' => $islogin,
            'user_info' => [
                'id' => $authenticatedUser->id,
                'username' => $authenticatedUser->username,
                'email' => $authenticatedUser->email,
                'updated_at' => $authenticatedUser->updated_at,
                'created_at' => $authenticatedUser->created_at,
                'is_logged_in' => $authenticatedUser->is_logged_in
            ],
            'client_info' => [
                'id' => $updatedClientInfo->id,
                'user_id' => $updatedClientInfo->user_id,
                'name' => $updatedClientInfo->name,
                'middlename' => $updatedClientInfo->middlename,
                'lastname' => $updatedClientInfo->lastname,
                'gender' => $updatedClientInfo->gender,
                'address' => $updatedClientInfo->address,
                'contact_number' => $updatedClientInfo->contact_number,
                'updated_at' => $updatedClientInfo->updated_at,
                'created_at' => $updatedClientInfo->created_at,
            ]
        ], 'Client information updated successfully');
    }
}
