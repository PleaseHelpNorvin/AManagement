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
        // Ensure the user is authenticated using Sanctum token
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Validate the request data
        $request->validate([
            'tenant_id' => 'required|exists:users,id', // Ensure the tenant exists
            'property_id' => 'required|exists:properties,id', // Ensure the property exists
            'rent_amount' => 'required|numeric|min:0', // Ensure rent amount is a positive number
            'late_fee' => 'required|numeric|min:0', // Ensure late fee is a positive number
            'security_deposit_amount' => 'required|numeric|min:0', // Ensure security deposit is a positive number
            'start_date' => 'required|date|after_or_equal:today', // Ensure the start date is today or in the future
            'payment_due_day' => 'required|in:15th,last_day', // Payment due day should be either "15th" or "last_day"
            'end_date' => 'nullable|date|after:start_date', // Ensure end date, if provided, is after the start date
        ]);

        // Generate a 7-digit random contract code with tenant prefix
        $contractCode = 'tenant-' . rand(1000000, 9999999);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
    
        // Calculate the difference in days between start and end dates
        $daysBetween = $startDate->diffInDays($endDate);

        // Create the contract using Contract::create
        $contract = Contract::create([
            'tenant_id' => $request->tenant_id, // Tenant ID
            'property_id' => $request->property_id, // Property ID
            'contract_code' => $contractCode, // Set the generated contract code
            'rent_amount' => $request->rent_amount, // Rent amount
            'late_fee' => $request->late_fee, // Late fee
            'security_deposit_amount' => $request->security_deposit_amount, // Security deposit amount
            'contract_date' => now(), // Set the contract creation date automatically
            'start_date' => $request->start_date, // Start date as provided by admin
            'payment_due_day' => $request->payment_due_day, // Payment due day (15th or last_day)
            'status' => 'pending', // Set initial contract status as pending
            'end_date' => $request->end_date, // End date (nullable)   
            'notice_period' => $daysBetween,
        ]);

        $tenantName = $contract->tenant->name;
        $propertyName = $contract->property->name;

        // dd($contract->tenant); 
        // Return a success response
        return $this->successResponse(['contract' => $contract,
        'tenant_name' => $tenantName, 'propert_name' =>$propertyName], 'Contract created successfully');
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

    public function viewContract  ($contractId)
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
