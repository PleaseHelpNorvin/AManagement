<?php

namespace App\Http\Controllers\rest;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends ApiController
{
    // Admin login (Issue Token)
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Find the user by email and check if they are an admin
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password) || !$user->isAdmin()) {
            // Return a custom error response if not an admin or incorrect credentials
            return $this->errorResponse(null, 'Invalid credentials or not an admin', 401);
        }

        // Issue token using Sanctum
        $token = $user->createToken('Admin-Token')->plainTextToken;

        // Return success response with token and role
        return $this->successResponse([
            'token' => $token,
            'role' => $user->role
        ], 'Admin login successful');
    }

    // Tenant login (Issue Token)
    public function tenantLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Find the user by email and check if they are a tenant
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password) || !$user->isTenant()) {
            // Return a custom error response if not a tenant or incorrect credentials
            return $this->errorResponse(null, 'Invalid credentials or not a tenant', 401);
        }

        // Issue token using Sanctum
        $token = $user->createToken('Tenant-Token')->plainTextToken;

        // Return success response with token and role
        return $this->successResponse([
            'token' => $token,
            'role' => $user->role,
            'tenant_id' =>$user->id
        ], 'Tenant login successful');
    }

    // Technician login (Issue Token)
    public function technicianLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Find the user by email and check if they are a technician
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password) || !$user->isTechnician()) {
            // Return a custom error response if not a technician or incorrect credentials
            return $this->errorResponse(null, 'Invalid credentials or not a technician', 401);
        }

        // Issue token using Sanctum
        $token = $user->createToken('Technician-Token')->plainTextToken;

        // Return success response with token and role
        return $this->successResponse([
            'token' => $token,
            'role' => $user->role,
            'tech_id' => $user->id,
        ], 'Technician login successful');
    }

    // Logout (Revoke Token)
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        // Return success response
        return $this->successResponse(null, 'Logged out successfully');
    }
}
