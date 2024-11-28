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
        return $this->successResponse($users, 'Users Retrived Successfully');
    }

    /**
     * Fetch a specific tenant's profile with related data
     */
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
