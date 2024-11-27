<?php

namespace App\Http\Controllers\rest;

use App\Http\Controllers\ApiController;
use App\Services\PayMongoService;
use Illuminate\Http\Request;

class PaymentController extends ApiController
{
    protected $payMongoService;

    public function __construct(PayMongoService $payMongoService)
    {
        $this->payMongoService = $payMongoService;
    }

    /**
     * Generate a payment link using PayMongo.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generatePaymentLink(Request $request)
    {
        // Validate request inputs
        $validator = $request->validate([
            'amount' => 'required|numeric|min:100', // Amount should be in centavos (e.g., 10000 for PHP 100)
            'description' => 'required|string|max:255', // Description of the payment
            'remarks' => 'required|string|max:255',
        ]);

        $amount = $request->amount;
        $description = $request->description;
        $remarks = $request->remarks;

        // Call the PayMongo service
        $response = $this->payMongoService->createCheckoutSession($amount, $description, $remarks);

        if (isset($response['error'])) {
            // Use custom errorResponse if PayMongo call fails
            return $this->errorResponse(
                $response['error'],
                'Failed to generate payment link.',
                500
            );
        }

        // Use custom successResponse to return the payment link
        return $this->successResponse(
            $response,
            'Payment link generated successfully.'
        );
    }
}
