<?php

namespace App\Http\Controllers\rest;

use App\Models\Room;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Property;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class TenantsController extends ApiController
{
    
    public function createTenantUser(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',  // password confirmation field should also be present in the request
    ]);

    // If validation fails, return validation error response
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Create a new user (tenant) using mass assignment
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),  // Hashing the password before saving
    ]);

    // Generate a Sanctum token for the new user
    $token = $user->createToken('Tenant-Registered-Token')->plainTextToken;

    // Log the user in after creation
    auth()->login($user);

    // Return a success response with a boolean for authentication status
    return $this->successResponse([
        'message' => 'Tenant user created and authenticated successfully',
        'token' => $token,
        'user' => $user,
        'is_authenticated' => auth()->check() // Check if the user is authenticated
    ]);
}



    public function createTenantUserProfile(Request $request)
{
    // Validate the incoming data
    $validator = Validator::make($request->all(), [
        'phone_number' => 'nullable|string|max:15',
        'address' => 'nullable|string|max:255',
        'profile_picture_url' => 'nullable',  // Assuming the URL format for the picture
        'emergency_contact' => 'nullable|string|max:15',
        'bio' => 'nullable|string|max:500',
    ]);

    // If validation fails, return validation error response
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Get the authenticated user's ID
    $userId = auth()->user()->id;

    // Check if the user exists
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Check if the profile already exists for the user
    $existingProfile = UserProfile::where('user_id', $userId)->first();
    if ($existingProfile) {
        return response()->json(['error' => 'Profile already exists for this user'], 409);
    }

    // Create a new profile for the tenant using mass-assignment
    $profile = UserProfile::create([
        'user_id' => $user->id,   // Link the profile to the authenticated user
        'phone_number' => $request->phone_number,
        'address' => $request->address,
        'profile_picture_url' => $request->profile_picture_url,
        'emergency_contact' => $request->emergency_contact,
        'bio' => $request->bio,
    ]);

    return response()->json(['message' => 'Tenant user profile created successfully', 'profile' => $profile], 201);
}


    public function index()
    {   //show all the users collections along its relationship
        $users = User::with([
            'tenants',
            'contracts',
            'maintenanceRequests',
            'messagesSent',
            'messagesReceived',
            'notifications',
        ])->where('role', 'tenant')->get(); // Retrieve all users
    
        // Return the data as a JSON response (you can adjust the format as needed)
        return $this->successResponse($users, 'Users Fetched Successfully');
    }

    // same with the index() but with the mapping
    public function showTenantsTable()
    {
        $users = User::with([
            'tenants',
            'contracts',
            'maintenanceRequests',
            'messagesSent',
            'messagesReceived',
            'notifications',
        ])->where('role', 'tenant')->get();

        // Mapping the user data to return specific fields
        $mappedData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'tenants' => $user->tenants->map(function ($tenant) {
                    return [
                        'tenant_id' => $tenant->id,
                        'tenant_name' => $tenant->user->name,
                        'lease_start' => $tenant->lease_start_date,
                        'lease_end' => $tenant->lease_end_date,
                    ];
                }),
                'contracts' => $user->contracts->map(function ($contract) {
                    return [
                        'contract_id' => $contract->id,
                        'start_date' => $contract->start_date,
                        'end_date' => $contract->end_date,
                    ];
                }),
                'maintenanceRequests' => $user->maintenanceRequests->map(function ($request) {
                    return [
                        'request_id' => $request->id,
                        'description' => $request->description,
                        'status' => $request->status,
                    ];
                }),
                'messagesSent' => $user->messagesSent->map(function ($message) {
                    return [
                        'message_id' => $message->id,
                        'content' => $message->message,
                        'sent_at' => $message->created_at,
                    ];
                }),
                'messagesReceived' => $user->messagesReceived->map(function ($message) {
                    return [
                        'message_id' => $message->id,
                        'content' => $message->message,
                        'received_at' => $message->created_at,
                    ];
                }),
                'notifications' => $user->notifications->map(function ($notification) {
                    return [
                        'notification_id' => $notification->id,
                        'status' => $notification->status,
                        'message' => $notification->message,
                        'created_at' => $notification->created_at,
                    ];
                }),
            ];
        });
        return $this->successResponse($mappedData, 'Tenants Map Retrieved Succesfully');
    }

    public function showProfile($tenantId)
    {
        // Retrieve the tenant by ID with related data
        $tenant = User::with([
            'tenants.maintenanceRequests', // Load maintenanceRequests through tenants relationship
            'contracts',
            'messagesSent',
            'messagesReceived',
            'notifications',
        ])->where('id', $tenantId)->where('role', 'tenant')->first();
    
        // Check if the tenant exists
        if (!$tenant) {
            return $this->errorResponse('Tenant not found', 404);
        }
    
        // Return the tenant's profile data as a JSON response
        return $this->successResponse($tenant, 'Tenant Profile Retrieved Successfully');
    }
    

    public function createMaintenanceRequest()
    {
        $tenant = User::with([
            'tenants',
            'contracts',
            'maintenanceRequests',
            'messagesSent',
            'messagesReceived',
            'notifications',
        ])->where('id', $tenantId)->where('role', 'tenant')->first();
    }
}
