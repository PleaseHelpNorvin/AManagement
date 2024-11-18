<?php

namespace App\Http\Controllers\pages\tenants;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;

class TenantController extends ApiController
{
    public function getTenants()
    {
        $tenants = User::where('role', 0)
            ->with('clientInformation')  // Eager load clientInformation
            ->get()
            ->map(function($tenant) {
                // Ensure clientInformation is null if it's not set
                $tenant->client_information = $tenant->clientInformation ?: null;
                return $tenant;
            });
    
        return $this->successResponse($tenants, 'Tenants fetched successfully');
    }

    public function updateTenant(Request $request, $tenantId)
    {
        // Find the tenant by ID
        $tenant = User::findOrFail($tenantId);
    
        // Validate and update the tenant details
        $tenant->update([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            // Add other fields here as needed
        ]);
    
        // Update client information if it's provided
        if ($request->has('client_information')) {
            $tenant->clientInformation()->update([
                'name' => $request->input('client_information.name'),
                'middlename' => $request->input('client_information.middlename'),
                'lastname' => $request->input('client_information.lastname'),
                'gender' => $request->input('client_information.gender'),
                'address' => $request->input('client_information.address'),
                'contact_number' => $request->input('client_information.contact_number'),
            ]);
        }
    
        // Return the formatted response
        return $this->successResponse(
            [
                'id' => $tenant->id,
                'username' => $tenant->username,
                'email' => $tenant->email,
                'email_verified_at' => $tenant->email_verified_at,
                'created_at' => $tenant->created_at,
                'updated_at' => $tenant->updated_at,
                'role' => $tenant->role,
                'is_logged_in' => $tenant->is_logged_in,
                'last_active_at' => $tenant->last_active_at,
                'client_information' => $tenant->clientInformation, // Includes updated client info
            ],
            'Tenant updated successfully'
        );
    }    


      // Fetch a tenant by ID
    public function getTenantById($tenantId)
    {
        // Fetch the tenant by ID with the associated client information
        $tenant = User::where('role', 0)  // Ensure you're filtering by role (0 for tenant)
            ->with('clientInformation')    // Eager load clientInformation
            ->find($tenantId);             // Use find to get the specific tenant by ID
    
        if (!$tenant) {
            return response()->json(['message' => 'Tenant not found'], 404);
        }
    
        // Ensure client_information is null if it's not set
        $tenant->client_information = $tenant->clientInformation ?: null;
    
        // Return the tenant data with a success response
        return $this->successResponse($tenant, 'Tenant fetched by id successfully');
    }

    public function deleteTenantById($tenantId)
    {
        try {
            // Find the tenant by ID
            $tenant = User::findOrFail($tenantId);

            // Delete the associated clientInformation manually
            if ($tenant->clientInformation) {
                $tenant->clientInformation->delete();
            }

            // Delete the tenant
            $tenant->delete();

            return response()->json([
                'message' => 'Tenant and associated client information deleted successfully.',
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error occurred while deleting tenant: ' . $e->getMessage(),
            ], 500);
        }
    }
}
