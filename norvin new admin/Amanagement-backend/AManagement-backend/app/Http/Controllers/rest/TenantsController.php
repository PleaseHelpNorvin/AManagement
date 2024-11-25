<?php

namespace App\Http\Controllers\rest;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

//models
use App\Models\Tenant;
use App\Models\Room;
use App\Models\User;
use App\Models\Property;

class TenantsController extends ApiController
{
    public function index()
{
    $tenants = User::with('tenant.room') // Eager load tenant, and then room
        ->where('role', 'tenant')
        ->get()
        ->map(function ($user) {
            $tenant = $user->tenant; // Get the tenant for the user
            
            // Check if the tenant or room relationship is missing
            if (!$tenant || !$tenant->room) {
                $user->status = 'no_room';
            } else {
                // Determine the tenant's status based on lease dates
                if ($tenant->start_date > now()) {
                    $user->status = 'not_started';
                } elseif ($tenant->end_date < now()) {
                    $user->status = 'evicted'; // Or 'inactive' depending on your use case
                } else {
                    $user->status = 'active';
                }

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'apartment' => $tenant->room->property_id, // Access room through tenant
                    'room' => $tenant->room->name, // Access room name through tenant
                    'leaseStart' => $tenant->start_date,
                    'leaseEnd' => $tenant->end_date,
                    'status' => $user->status,
                ];
            }
        });

    return response()->json([
        'data' => $tenants,
    ]);
}

    public function show($tenantId)
{
    // Fetch tenant with maintenance requests
    $tenant = Tenant::with(['user', 'room', 'payments', 'maintenanceRequests'])
        ->where('id', $tenantId)
        ->first();

    if (!$tenant) {
        return $this->notFoundResponse(null, 'Tenant not found');
    }

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
        'status' => $tenant->user->status,
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

    return $this->successResponse($tenantData);
}
    
}
