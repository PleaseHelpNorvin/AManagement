<?php

namespace App\Http\Controllers\rest;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\ContractSetting;
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
            return $this->errorResponse(null, 'Unauthorized', 401);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'tenant_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date|after_or_equal:today',
            'payment_due_day' => 'required|in:15th,last_day',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        // Fetch the room
        $room = Room::findOrFail($validatedData['room_id']);

        // Fetch contract settings
        $settings = ContractSetting::first();
        if (!$settings) {
            return $this->notFoundResponse(null, 'Contract settings not found');
        }

        // Calculate late fee and security deposit
        $lateFee = ($settings->late_fee_percentage / 100) * $room->rent_amount;
        $securityDeposit = ($settings->security_deposit_percentage / 100) * $room->rent_amount;

        // Generate contract details
        $contractCode = 'tenant-' . rand(1000000, 9999999);
        $startDate = Carbon::parse($validatedData['start_date']);
        $endDate = $request->end_date ? Carbon::parse($validatedData['end_date']) : null;
        $noticePeriod = $endDate ? $startDate->diffInDays($endDate) : null;

        // Create the contract
        $contract = Contract::create([
            'tenant_id' => $validatedData['tenant_id'],
            'property_id' => $validatedData['property_id'],
            'contract_code' => $contractCode,
            'rent_amount' => $room->rent_amount,
            'late_fee' => $lateFee,
            'security_deposit_amount' => $securityDeposit,
            'contract_date' => now(),
            'start_date' => $validatedData['start_date'],
            'payment_due_day' => $validatedData['payment_due_day'],
            'status' => 'pending',
            'end_date' => $request->end_date ?? null,
            'notice_period' => $noticePeriod,
        ]);

        // Format the response data
        $response = [
            'contract_details' => [
                'contract_code' => $contract->contract_code,
                'status' => $contract->status,
                'contract_date' => $contract->contract_date,
                'start_date' => $contract->start_date,
                'end_date' => $contract->end_date,
                'payment_due_day' => $contract->payment_due_day,
            ],
            'calculated_amounts' => [
                'rent_amount' => $room->rent_amount,
                'late_fee' => $lateFee,
                'security_deposit' => $securityDeposit,
            ],
            'room_details' => [
                'room_name' => $room->room_code,
            ],
            'tenant_details' => [
                'name' => $contract->tenant->name,
            ],
            'property_details' => [
                'name' => $contract->property->name,
            ],
        ];

        return $this->successResponse($response, 'Contract created successfully');
    }

    public function generateContract($contractCode)
    {
        // Fetch contract and related data using contract_code instead of id
        $contract = Contract::with('tenant', 'property')->where('contract_code', $contractCode)->firstOrFail();

        // Generate PDF using a view
        $pdf = Pdf::loadView('contract', compact('contract'));

        // Define file path
        $filePath = public_path('storage/contracts/contract_' . $contract->contract_code . '.pdf');
        
        // Save the PDF to the file path
        $pdf->save($filePath);

        // Return the generated PDF as a download
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

    public function showContract($tenantId)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return $this->errorResponse(null, 'Unauthorized', 401);
        }
    
        // Fetch contracts by tenant_id and include related data
        $contracts = Contract::with('tenant', 'property')
                             ->where('tenant_id', $tenantId)
                             ->get();
    
        // Handle case where no contracts are found
        if ($contracts->isEmpty()) {
            return $this->notFoundResponse(null, 'No contracts found for this tenant');
        }
    
        // Map contracts to a structured response
        $response = $contracts->map(function ($contract) {
            return [

                'id' => $contract->id,
                'tenant_id' => $contract->tenant_id,
                'contract_code' => $contract->contract_code,
                'status' => $contract->status,
                'contract_date' => $contract->contract_date,
                'start_date' => $contract->start_date,
                'end_date' => $contract->end_date,
                'payment_due_day' => $contract->payment_due_day,
                'tenant_details' => [
                    'name' => $contract->tenant->name,
                ],
                'property_details' => [
                    'name' => $contract->property->name,
                ],
            ];
        });
    
        // Return the response
        return $this->successResponse($response, 'Contracts fetched successfully');
    }

}
