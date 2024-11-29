<?php

namespace App\Http\Controllers\rest;

use App\Models\User;
use App\Models\Contract;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class TenantRegisterController extends ApiController
{
    //

    // public function createTenantUser(Request $request)
    // {
    //     // Validate the request
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8',  // password confirmation field should also be present in the request
    //     ]);

    //     // If validation fails, return validation error response
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     // Create a new user (tenant) using mass assignment
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),  // Hashing the password before saving
    //     ]);

    //     // Generate a Sanctum token for the new user
    //     $token = $user->createToken('Tenant-Registered-Token')->plainTextToken;

    //     // Log the user in after creation
    //     auth()->login($user);

    //     // Return a success response with a boolean for authentication status
    //     return $this->successResponse([
    //         'message' => 'Tenant user created and authenticated successfully',
    //         'token' => $token,
    //         'user' => $user,
    //         'is_authenticated' => auth()->check() // Check if the user is authenticated
    //     ]);
    // }


    // public function createTenantUserProfile(Request $request)
    // {
    //     // Validate the incoming data
    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'required|exists:users,id', // Ensure the user exists in the users table
    //         'phone_number' => 'nullable|string|max:15',
    //         'address' => 'nullable|string|max:255',
    //         'profile_picture_url' => 'nullable',  // Assuming the URL format for the picture
    //         'emergency_contact' => 'nullable|string|max:15',
    //         'bio' => 'nullable|string|max:500',
    //     ]);

    //     // If validation fails, return validation error response
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     // Create a new profile for the tenant using mass-assignment
    //     $profile = UserProfile::create([
    //         'user_id' => $request->user_id,   // Link the profile to the existing user
    //         'phone_number' => $request->phone_number,
    //         'address' => $request->address,
    //         'profile_picture_url' => $request->profile_picture_url,
    //         'emergency_contact' => $request->emergency_contact,
    //         'bio' => $request->bio,
    //     ]);

    //     return response()->json(['message' => 'Tenant user profile created successfully', 'profile' => $profile], 201);
    // }

    public function getContractTemplate()
    {
        $contract_template = Contract::where('status', 'template')->get();

        return $this->successResponse($contract_template, 'contract with template status is fetch successfully');
    }

    // public function createContractForTenant(Request $request, $contractId)
    // {
    //     // Validate incoming request data
    //     $validator = Validator::make($request->all(), [
    //         'tenant_id' => 'nullable|exists:users,id', // tenant_id must exist in the users table (if provided)
    //         'property_id' => 'nullable|exists:properties,id', // property_id must exist in the properties table (if provided)
    //         'start_date' => 'required|date',
    //         'end_date' => 'required|date|after_or_equal:start_date', // Ensure end date is after or equal to start date
    //         'rent_amount' => 'required|numeric|min:0',
    //         'security_deposit' => 'required|numeric|min:0',
    //         'payment_due_date' => 'required|date',
    //     ]);

    //     // If validation fails, return validation error response
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     // Find the original contract (template) by ID
    //     $templateContract = Contract::find($contractId);

    //     if (!$templateContract) {
    //         return response()->json(['error' => 'Contract template not found'], 404);
    //     }

    //     // Create a new contract based on the template, with tenant's details
    //     $newContract = new Contract();

    //     // Check if tenant_id is provided and assign it, else leave it null
    //     $newContract->tenant_id = $request->has('tenant_id') ? $request->tenant_id : null;

    //     // Check if property_id is provided and assign it, else leave it null
    //     $newContract->property_id = $request->has('property_id') ? $request->property_id : null;

    //     // Copy contract details from the template
    //     $newContract->contract_type = $templateContract->contract_type;
    //     $newContract->start_date = $request->start_date;
    //     $newContract->end_date = $request->end_date;
    //     $newContract->rent_amount = $request->rent_amount;
    //     $newContract->security_deposit = $request->security_deposit;
    //     $newContract->payment_due_date = $request->payment_due_date;
    //     $newContract->status = 'active';  // Mark the new contract as active
    //     $newContract->save();  // Save the new contract

    //     // Optionally, mark the template contract as finalized
    //     $templateContract->status = 'finalized';
    //     $templateContract->save();

    //     return response()->json(['message' => 'Contract created successfully', 'contract' => $newContract]);
    // }

    public function createTenantRecord($tenantId, $propertyId, $startDate, $endDate)
    {
        // Ensure the tenant exists
        $tenant = Tenant::find($tenantId);

        if (!$tenant) {
            return response()->json(['error' => 'Tenant not found.'], 404);
        }

        // Create the tenant record
        $tenant->update([
            'room_id' => $propertyId, // Assuming the room ID is the property ID for simplicity, adjust accordingly
            'lease_start_date' => $startDate,
            'lease_end_date' => $endDate,
            'status' => 'active', // Status of the tenant (pending, active, etc.)
        ]);
    }

    
}
