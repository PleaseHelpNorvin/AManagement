<?php

namespace App\Http\Controllers\rest;

use App\Http\Controllers\ApiController; // Extend from ApiController
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\ContractSetting;

class ContractSettingController extends ApiController
{
    /**
     * Get the current contract settings.
     */
    public function index()
    {
        $settings = ContractSetting::first();

        if (!$settings) {
            return $this->notFoundResponse(null, 'Contract settings not found');
        }

        return $this->successResponse(['settings' => $settings], 'Contract settings retrieved successfully');
    }

    /**
     * Create or update contract settings.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'late_fee_percentage' => 'required|numeric|min:0|max:100',
            'security_deposit_percentage' => 'required|numeric|min:0|max:100',
        ]);

        // Check if settings already exist
        $settings = ContractSetting::first();

        if ($settings) {
            // Update existing settings
            $settings->update($validatedData);
        } else {
            // Create new settings
            $settings = ContractSetting::create($validatedData);
        }

        return $this->successResponse(['settings' => $settings], 'Contract settings saved successfully');
    }

    /**
     * Calculate the late fee and security deposit for a given rent amount.
     */
    public function calculate(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        // Fetch the room
        $room = Room::find($validatedData['room_id']);

        if (!$room) {
            return $this->notFoundResponse(null, 'Room not found');
        }

        // Fetch contract settings
        $settings = ContractSetting::first();

        if (!$settings) {
            return $this->notFoundResponse(null, 'Contract settings not found');
        }

        // Perform calculations
        $lateFee = ($settings->late_fee_percentage / 100) * $room->rent_amount;
        $securityDeposit = ($settings->security_deposit_percentage / 100) * $room->rent_amount;

        return $this->successResponse([
            'room_name' => $room->room_code,
            'room_rent_amount' => $room->rent_amount,
            'late_fee' => $lateFee,
            'security_deposit' => $securityDeposit,
        ], 'Calculations completed successfully');
    }
}
