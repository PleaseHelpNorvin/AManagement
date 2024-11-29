<?php

namespace App\Http\Controllers\rest;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;

use App\Models\User;

class MaintenanceRequestController extends ApiController
{
    //
    public function index()
    {
        $maintenancerequests = MaintenanceRequest::with(['tenant', 'property.rooms'])->get();

        if ($maintenancerequests->isEmpty()) {
            return $this->notFoundResponse(null, 'No unassigned maintenance requests found');
        }

        $formatted = $maintenancerequests->map(function ($request) {

            // Access tenant relationship data
            $tenant = $request->tenant; // Access tenant from current request object
            $property = $request->property; // Access property from current request object

            // Get tenant's room using the room relationship in the Tenant model
            $tenantRoom = $tenant ? $tenant->room : null; // Ensure $tenant is not null
            $roomName = $tenantRoom ? $tenantRoom->room_code : null; // Room code from room relationship

            return [
                'id' => $request->id,
                'priority' => $request->priority,
                'requestor' => $request->tenant_id,
                'requestor_name' => $tenant ? $tenant->user->name : null, // Accessing tenant's user name
                'requestor_email' => $tenant ? $tenant->user->email : null, // Accessing tenant's email
                'property_id' => $property->id,
                'property_name' => $property->name,
                'address' => $property->address,
                'room_code' => $roomName, // The specific room the tenant resides in
                'description' => $request->description,
                'status' => $request->status,
                'reported_at' => $request->reported_at,
                'resolved_at' => $request->resolved_at,
            ];
        });

        return $this->successResponse($formatted, 'Maintenance Requests Fetched Successfully');
    }

    public function showById($maintenanceId)
    {
        $maintenancerequest = MaintenanceRequest::with(['tenant','property.rooms'])
        ->where('id', $maintenanceId)->first();


        if (!$maintenancerequest) {
            return $this->notFoundResponse(null, 'Maintenance request not found');
        }

        // Access relationships and format the data
        $tenant = $maintenancerequest->tenant; // Access tenant from the request object
        $property = $maintenancerequest->property; // Access property from the request object

        // Get tenant's room using the room relationship in the Tenant model
        $tenantRoom = $tenant ? $tenant->room : null; // Ensure $tenant is not null
        $roomName = $tenantRoom ? $tenantRoom->room_code : null; // Room code from room relationship

        $formatted = [
            'id' => $maintenancerequest->id,
            'priority' => $maintenancerequest->priority,
            'requestor' => $maintenancerequest->tenant_id,
            'requestor_name' => $tenant ? $tenant->user->name : null, // Accessing tenant's user name
            'requestor_email' => $tenant ? $tenant->user->email : null, // Accessing tenant's email
            'property_id' => $property->id,
            'property_name' => $property->name,
            'address' => $property->address,
            'room_code' => $roomName, // The specific room the tenant resides in
            'description' => $maintenancerequest->description,
            'status' => $maintenancerequest->status,
            'reported_at' => $maintenancerequest->reported_at,
            'resolved_at' => $maintenancerequest->resolved_at,
        ];

        return $this->successResponse($formatted, 'Maintenance Request Fetched By Id Successfully');
    }

    

}
