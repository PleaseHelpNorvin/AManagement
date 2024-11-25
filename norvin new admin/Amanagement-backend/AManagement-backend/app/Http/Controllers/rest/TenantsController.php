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
    // get tenant no payment logic
    // public function index()
    // {
    //     // Fetch tenants with the necessary relationships
    //     $tenants = Tenant::with(['user', 'room', 'room.property', 'payments'])
    //         ->get()
    //         ->map(function ($tenant) {
    //             // Format the data for the table view
    //             return [
    //                 'id' => $tenant->id,
    //                 'name' => $tenant->user->name,
    //                 'property' => $tenant->room->property->unit_name,
    //                 'apartment' => $tenant->room->name,
    //                 'dueDate' => $tenant->payments->last()->due_date ?? null, // Last payment due date
    //                 'lastPayment' => $tenant->payments->last()->created_at ?? null, // Last payment date
    //                 'paymentStatus' => $tenant->payments->last()->status ?? 'Pending', // Last payment status
    //             ];
    //         });

    //     // Use successResponse from ApiController
    //     return $this->successResponse($tenants);
    // }
    public function index()
    {
        // Fetch tenants with the necessary relationships, including all payments
        $tenants = Tenant::with(['user', 'room', 'room.property', 'payments'])
            ->get()
            ->map(function ($tenant) {
                // Format the data for the table view, including all the necessary fields
                return [
                    'id' => $tenant->id,
                    'name' => $tenant->user->name,
                    'property' => $tenant->room->property->unit_name,
                    'apartment' => $tenant->room->name,
                    'payments' => $tenant->payments->map(function ($payment) {
                        // Include all payment details, adjust based on the payment fields available
                        return [
                            'dueDate' => $payment->due_date,
                            'createdAt' => $payment->created_at,
                            'status' => $payment->status,
                            'amount' => $payment->amount, // Adjust with actual payment field name
                        ];
                    }),
                ];
            });
    
        // Use successResponse from ApiController
        return $this->successResponse($tenants);
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
