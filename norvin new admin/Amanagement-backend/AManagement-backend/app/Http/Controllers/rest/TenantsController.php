<?php

namespace App\Http\Controllers\rest;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

//models
use App\Models\Tenant;
use App\Models\Room;


class TenantsController extends ApiController
{
    //
   
    public function index()
    {
        // Fetch tenants with the necessary relationships
        $tenants = Tenant::with(['user', 'room', 'room.property', 'payments'])
            ->get()
            ->map(function ($tenant) {
                // Format the data for the table view
                return [
                    'id' => $tenant->id,
                    'name' => $tenant->user->name,
                    'property' => $tenant->room->property->unit_name,
                    'apartment' => $tenant->room->name,
                    'dueDate' => $tenant->payments->last()->due_date ?? null, // Last payment due date
                    'lastPayment' => $tenant->payments->last()->created_at ?? null, // Last payment date
                    'paymentStatus' => $tenant->payments->last()->status ?? 'Pending', // Last payment status
                ];
            });

        // Use successResponse from ApiController
        return $this->successResponse($tenants);
    }

    public function show($tenantId)
    {
        // Fetch tenant by ID with the necessary relationships
        $tenant = Tenant::with(['user', 'room', 'payments', 'maintenance_requests'])
            ->where('id', $tenantId)
            ->first();

        if (!$tenant) {
            // Use notFoundResponse from ApiController
            return $this->notFoundResponse(null, 'Tenant not found');
        }

        // Prepare the data to return in the detailed view
        $tenantData = [
            'id' => $tenant->id,
            'name' => $tenant->user->name,
            'apartment' => $tenant->room->name,
            'dueDate' => $tenant->payments->last()->due_date ?? null, 
            'lastPayment' => $tenant->payments->last()->created_at ?? null,
            'paymentStatus' => $tenant->payments->last()->status ?? 'Pending',
            'phone' => $tenant->user->phone,
            'email' => $tenant->user->email,
            'leaseStartDate' => $tenant->user->lease_start,
            'leaseEndDate' => $tenant->user->lease_end,
            'paymentHistory' => $tenant->payments->map(function ($payment) {
                return [
                    'date' => $payment->due_date->format('Y-m-d'),
                    'amount' => '$' . number_format($payment->amount, 2),
                ];
            }),
            'maintenanceRequests' => $tenant->maintenanceRequests->map(function ($request) {
                return [
                    'description' => $request->description,
                    'status' => $request->status,
                ];
            }),
        ];

        // Use successResponse from ApiController
        return $this->successResponse($tenantData);
    }

    
}
