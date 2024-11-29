<?php

namespace App\Http\Controllers\rest;

use Carbon\Carbon;
use App\Models\Tenant;
use App\Models\Contract;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;



class ContractController extends ApiController
{
    //

    public function createContract(Request $request)
    {
        // Ensure the authenticated user is a tenant
        $user = auth()->user();

        if (!$user || !$user->isTenant()) {
            return response()->json([
                'message' => 'Only tenants can create contracts.',
            ], 403); // Forbidden
        }

        // Validate request data
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id', // Validate property exists in the properties table
            'contract_type' => 'required|in:template,fixed,monthly,annual,one_time',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'rent_amount' => 'required|numeric|min:0',
            'security_payment' => 'required|numeric|min:0',
            'payment_frequency' => 'required|in:monthly,annually,one_time',
            'payment_due_date' => 'required|date',
            'late_fee' => 'nullable|numeric|min:0',
            'total_paid' => 'nullable|numeric|min:0',
            'renewal_date' => 'nullable|date',
            'status' => 'required|in:template,active,expired,terminated,finalized',
            'special_terms' => 'nullable|string',
            'is_renewable' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Retrieve the tenant record for the logged-in user
            // $tenant = Tenant::where('user_id', auth()->id())->first();

            if (!$user) {
                return response()->json([
                    'message' => 'Tenant record not found for the authenticated user.',
                ], 404);
            }

            // Creating a new contract record
            $contract = Contract::create([
                'tenant_id' => $user->id, // Automatically set the tenant ID
                'property_id' => $validated['property_id'],
                'contract_type' => $validated['contract_type'],
                'start_date' => Carbon::parse($validated['start_date']),
                'end_date' => $validated['end_date'] ? Carbon::parse($validated['end_date']) : null,
                'rent_amount' => $validated['rent_amount'],
                'security_payment' => $validated['security_payment'],
                'payment_frequency' => $validated['payment_frequency'],
                'payment_due_date' => Carbon::parse($validated['payment_due_date']),
                'late_fee' => $validated['late_fee'] ?? 0.00,
                'total_paid' => $validated['total_paid'] ?? 0.00,
                'renewal_date' => $validated['renewal_date'] ? Carbon::parse($validated['renewal_date']) : null,
                'status' => $validated['status'],
                'special_terms' => $validated['special_terms'] ?? 'The tenant agrees to pay for utilities (electricity, water, etc.).',
                'is_renewable' => $validated['is_renewable'],
                'notes' => $validated['notes'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Contract created successfully',
                'contract' => $contract,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create contract',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function generateContract($contractId)
    {
        // Fetch contract and related data
        $contract = Contract::with('tenant', 'property')->findOrFail($contractId);

        // Generate PDF using a view  // now its working
        $pdf = Pdf::loadView('contract', compact('contract'));

        $filePath = public_path('contracts/contract_' . $contract->id . '.pdf');
        $pdf->save($filePath);
        return response()->download($filePath);
    }

    public function n  ($contractId)
    {
        // Retrieve contract and related data
        $contract = Contract::with('tenant', 'property')->findOrFail($contractId);

        // Pass the contract data to the Blade view
        return view('contract', compact('contract'));
    }

    public function getContract()
    {
        // $contract_template = Contract::where('status', 'template')->get();
        $contract_template = Contract::with('tenant','property')->get();
        return $this->successResponse($contract_template, 'contract with template status is fetch successfully');
    }

}
