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
    {
        $tenants = User::with(['tenant.room.property']) // Eager load tenant, room, and property
            ->where('role', 'tenant')
            ->get()
            ->map(function ($user) {
                $tenant = $user->tenant;

                // Determine tenant status based on lease dates and room availability
                $user->status = $this->getTenantStatus($tenant);
              

                if ($tenant && $tenant->room) {
                    return [
                        'user_id' => $user->id,
                        'tenant_id' => $tenant->id,
                        'tenant_code' => $user->tenant->tenant_code,
                        'name' => $user->name,
                        'apartment' => $tenant->room->property->unit_name ?? 'N/A',
                        'room' => $tenant->room->name,
                        'monthly_rent' => $user->tenant->monthly_rent,
                        'leaseStart' => $tenant->lease_start,
                        'leaseEnd' => $tenant->lease_end,
                        'status' => $user->status,
                    ];
                }

                return null; // Return null if tenant or room does not exist
            })
            ->filter() // Remove null values
            ->values(); // Re-index array to remove gaps

        return response()->json([
            'data' => $tenants,
        ]);
    }

    /**
     * Helper method to determine tenant status based on dates
     */
    protected function getTenantStatus($tenant)
    {
        if (!$tenant || !$tenant->room) {
            return 'no_room';
        }

        if ($tenant->lease_start > now()) {
            return 'not_started';
        } elseif ($tenant->lease_end < now()) {
            return 'evicted'; // Or 'inactive'
        } else {
            return 'active';
        }
    }

    /**
     * Fetch a specific tenant's profile with related data
     */
    public function showProfile($tenantId)
    {
        $tenant = Tenant::with(['user', 'room.property', 'payments', 'maintenanceRequests'])
            ->where('id', $tenantId)
            ->first();

        if (!$tenant) {
            return $this->notFoundResponse(null, 'Tenant not found');
        }

        // Get the latest payment for the tenant
        $latestPayment = $tenant->payments->last();

        // Format tenant profile data
        $tenantData = [
            'id' => $tenant->id,
            'user_id' => $tenant->user->id,
            'tenant_code' => $tenant->tenant_code,
            'name' => $tenant->user->name,
            'apartment' => $tenant->room->property->unit_name ?? 'N/A',
            'room' => $tenant->room->name,
            'leaseStart' => $tenant->lease_start,
            'leaseEnd' => $tenant->lease_end,
            'status' => $this->getTenantStatus($tenant),
            'phone' => $tenant->user->phone,
            'email' => $tenant->user->email,
            'latestPayment' => [
                'date' => $latestPayment ? $latestPayment->created_at->format('Y-m-d') : null,
                'amount' => $latestPayment ? number_format($latestPayment->amount, 2) : '0.00',
                'status' => $latestPayment ? $latestPayment->status : 'Pending',
            ],
            'paymentHistory' => $tenant->payments->map(function ($payment) {
                return [
                    'date' => $payment->created_at->format('Y-m-d'),
                    'amount' => number_format($payment->amount, 2),
                    'status' => $payment->status,
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
