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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TenantsController extends ApiController
{

    public function getUserProfile($userId)
    {
        // Fetch the user with the related user profile using eager loading
        $user = User::with('userProfile')->find($userId);

        // Check if the user exists
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        // Return the user data with profile information
        return response()->json([
            'success' => true,
            'message' => 'Tenant Profile Retrieved Successfully',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'profile_picture_url' => $user->userProfile ? $user->userProfile->profile_picture_url : null,
                'bio' => $user->userProfile ? $user->userProfile->bio : null,
                'phone_number' => $user->userProfile ? $user->userProfile->phone_number : null,
                'address' => $user->userProfile ? $user->userProfile->address : null,
                'emergency_contact' => $user->userProfile ? $user->userProfile->emergency_contact : null,
            ],
        ]);
    }
    
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
            'profile_picture_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Image validation
            'emergency_contact' => 'nullable|string|max:15',
            'bio' => 'nullable|file|mimes:png,jpg,pdf,docx,txt|max:5120', // Bio validation
        ]);
    
        // If validation fails, return validation error response
        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }
    
        // Get the authenticated user's ID
        $userId = auth()->user()->id;
    
        // Check if the user exists
        $user = User::find($userId);
    
        if (!$user) {
            return $this->notFoundResponse(null, 'User not found');
        }
    
        // Check if the profile already exists for the user
        $existingProfile = UserProfile::where('user_id', $userId)->first();
        if ($existingProfile) {
            return $this->errorResponse(null, 'Profile already exists for this user', 409);
        }
    
        // Ensure required folders exist
        if (!file_exists(public_path('profile_pictures'))) {
            mkdir(public_path('profile_pictures'), 0777, true);
        }
        if (!file_exists(public_path('bios'))) {
            mkdir(public_path('bios'), 0777, true);
        }
    
        // Handle file uploads (profile picture and bio)
        $profilePictureUrl = null;
        $bio = null;
    
        // Store profile picture with user ID in the file name
        if ($request->hasFile('profile_picture_url')) {
            $profilePictureUrl = $request->file('profile_picture_url')->storeAs(
                'profile_pictures', 
                'user_' . $userId . '_profile_picture.' . $request->file('profile_picture_url')->getClientOriginalExtension(),
                'public'
            );
    
            // Ensure file exists after upload
            if (!Storage::disk('public')->exists($profilePictureUrl)) {
                return $this->errorResponse(null, 'Failed to save profile picture.', 500);
            }
        }
    
        // Store bio with user ID in the file name
        if ($request->hasFile('bio')) {
            $bio = $request->file('bio')->storeAs(
                'bios', 
                'user_' . $userId . '_bio.' . $request->file('bio')->getClientOriginalExtension(),
                'public'
            );
    
            // Ensure file exists after upload
            if (!Storage::disk('public')->exists($bio)) {
                return $this->errorResponse(null, 'Failed to save bio.', 500);
            }
        }
    
        // Create a new profile for the tenant using mass-assignment
        $profile = UserProfile::create([
            'user_id' => $user->id,   // Link the profile to the authenticated user
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'profile_picture_url' => $profilePictureUrl ? asset('storage/' . $profilePictureUrl) : null, // Generate accessible URL
            'emergency_contact' => $request->emergency_contact,
            'bio' => $bio ? asset('storage/' . $bio) : null, // Generate accessible URL
        ]);
    
        return $this->successResponse($profile, 'Tenant user profile created successfully', 201);
    }

    public function createTenantRecord(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',  // Ensure the user exists
            'lease_start_date' => 'required|date',
            'lease_end_date' => 'nullable|date',
            'room_id' => 'required|exists:rooms,id',  // Ensure the room exists
            // 'status' => 'required|string',  // e.g., active or inactive
        ]);

        // If validation fails, return validation error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new tenant record
        $tenant = Tenant::create([
            'user_id' => $request->user_id,
            'lease_start_date' => $request->lease_start_date,
            'lease_end_date' => $request->lease_end_date,
            'room_id' => $request->room_id,
            'status' => 'active',
        ]);

        return response()->json(['message' => 'Tenant record created successfully', 'tenant' => $tenant], 201);
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
