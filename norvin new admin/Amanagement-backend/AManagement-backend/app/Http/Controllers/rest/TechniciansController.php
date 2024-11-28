<?php

namespace App\Http\Controllers\rest;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MaintenanceRequest;

class TechniciansController extends ApiController
{
    // Fetch all technicians
    public function index()
    {
        $technicians = User::with([
            'tenants',
            'contracts',
            'maintenanceRequests',
            'messagesSent',
            'messagesReceived',
            'notifications',
        ])->where('role', 'technician')->get();

        return $this->successResponse($technicians, 'Technicians fetched successfully');
    }

    // Fetch mapped technicians with specific fields
    public function mappedTechnicians()
    {
        $technicians = User::with([
            'maintenanceRequests',
            'messagesSent',
            'messagesReceived',
        ])->where('role', 'technician')->get();

        $formatted = $technicians->map(function ($technician) {
            return [
                'id' => $technician->id,
                'name' => $technician->name,
                'email' => $technician->email,
                'maintenanceRequests' => $technician->maintenanceRequests->isNotEmpty() ? $technician->maintenanceRequests : null,
                'messagesSent' => $technician->messagesSent->isNotEmpty() ? $technician->messagesSent : null,
            ];
        });

        return $this->successResponse($formatted, 'Mapped technicians fetched successfully');
    }

    // Fetch a specific technician's profile
    public function showProfile($technicianId)
    {
        // Fetch the technician with relationships
        $technician = User::with([
            'tenants',
            'contracts',
            'maintenanceRequests',
            'messagesSent',
            'messagesReceived',
            'notifications',
        ])->where('id', $technicianId)->where('role', 'technician')->first();

        $requests = MaintenanceRequest::where('technician_id', $technicianId)->get();

        // Check if the technician exists
        if (!$technician) {
            return $this->notFoundResponse(null, 'Technician not found');
        }

        // Format the technician data
        $formatted = [
            'id' => $technician->id,
            'name' => $technician->name,
            'email' => $technician->email,
            'maintenanceRequests' => $requests->isNotEmpty() ? $requests : null,
            'messagesSent' => $technician->messagesSent->isNotEmpty() ? $technician->messagesSent : null,
            'messagesReceived' => $technician->messagesReceived->isNotEmpty() ? $technician->messagesReceived : null,
            'notifications' => $technician->notifications->isNotEmpty() ? $technician->notifications : null,
        ];

        return $this->successResponse($formatted, 'Technician profile retrieved successfully');
    }

    // Fetch maintenance requests assigned to the authenticated technician
    public function myAssignedRequests()
    {
        $user = auth()->user();

        if (!$user || !$user->isTechnician()) {
            return $this->forbiddenResponse(null, 'Unauthorized access');
        }

        $requests = $user->maintenanceRequestsAssigned()->with(['tenant', 'property'])->get();

        return $this->successResponse($requests, 'Assigned maintenance requests retrieved successfully');
    }

    // Accept a maintenance request
    public function acceptRequest($id)
    {
        $user = auth()->user();

        if (!$user || !$user->isTechnician()) {
            return $this->forbiddenResponse(null, 'Unauthorized access');
        }

        $request = MaintenanceRequest::find($id);

        if (!$request) {
            return $this->notFoundResponse(null, 'Request not found');
        }

        if ($request->technician_id) {
            return $this->errorResponse(null, 'Request is already assigned', 400);
        }

        $request->technician_id = $user->id;
        $request->status = 'in-progress';
        $request->save();

        return $this->successResponse($request, 'Request accepted successfully');
    }

    public function getAllNullMainteRequests()
{
    // Fetch maintenance requests where technician_id is null (not assigned), with related tenant data
    $requests = MaintenanceRequest::with(['tenant'])->whereNull('technician_id')->get();

    // Check if there are any requests
    if ($requests->isEmpty()) {
        return $this->notFoundResponse(null, 'No unassigned maintenance requests found');
    }

    // Format the response
    $formatted = $requests->map(function ($request) {
        // Access tenant relationship data
        $tenant = $request->tenant; // This accesses the tenant relationship

        return [
            'id' => $request->id,
            'priority' => $request->priority,
            'tenant_id' => $request->tenant_id,
            'tenant_name' => $tenant ? $tenant->user->name : null, // Accessing tenant's user name
            'tenant_email' => $tenant ? $tenant->user->email : null, // Accessing tenant's email
            'property_id' => $request->property_id,
            'description' => $request->description,
            'status' => $request->status,
            'reported_at' => $request->reported_at,
            'resolved_at' => $request->resolved_at,
        ];
    });

    return $this->successResponse($formatted, 'Unassigned maintenance requests retrieved successfully');
}
    
}
