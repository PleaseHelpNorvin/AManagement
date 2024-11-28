<?php

namespace App\Http\Controllers\rest;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Room;
use App\Models\User;
use App\Models\Property;

class TenantsController extends ApiController
{
    /**
     * Fetch all tenants along with related data (property, room, etc.)
     */
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
        return $this->successResponse($users, 'Users fetched Successfully');
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
        // Retrieve the tenant's profile by ID with related data
        $tenant = User::with([
            'tenants',
            'contracts',
            'maintenanceRequests',
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
}
