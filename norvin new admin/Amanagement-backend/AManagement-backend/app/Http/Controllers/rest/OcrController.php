<?php

namespace App\Http\Controllers\rest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;  // Import the Tesseract OCR class


class OcrController extends Controller
{
    //
    // not yet ready
    public function processImage(Request $request)
    {
        // Validate the uploaded image
        $request->validate([
            'electric_meter_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'water_meter_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tenant_id' => 'required|exists:users,id',
            'contract_id' => 'required|exists:contracts,id',
        ]);

        // Store the images
        $electricPath = $request->file('electric_meter_picture')->store('images');
        $waterPath = $request->file('water_meter_picture')->store('images');

        // Perform OCR on the images
        $electricText = (new TesseractOCR(storage_path('app/' . $electricPath)))->run();
        $waterText = (new TesseractOCR(storage_path('app/' . $waterPath)))->run();

        // Extract numbers from the OCR results
        preg_match_all('/\d+/', $electricText, $electricMatches);
        preg_match_all('/\d+/', $waterText, $waterMatches);

        // Get the first numbers as readings
        $electricReading = $electricMatches[0][0] ?? null;
        $waterReading = $waterMatches[0][0] ?? null;

        // Store the billing record
        $billing = Billing::create([
            'tenant_id' => $request->tenant_id,
            'contract_id' => $request->contract_id,
            'amount_due' => $this->calculateAmountDue($electricReading, $waterReading),  // Calculate based on readings
            'amount_paid' => 0,  // Initially 0, can be updated later
            'electric_meter_picture' => file_get_contents(storage_path('app/' . $electricPath)),
            'water_meter_picture' => file_get_contents(storage_path('app/' . $waterPath)),
            'electric_reading' => $electricReading,
            'water_reading' => $waterReading,
            'payment_status' => 'pending',
            'billing_period_start' => now(),
            'billing_period_end' => now()->addMonth(), // You can adjust this as needed
        ]);

        return response()->json($billing);
    }
}
