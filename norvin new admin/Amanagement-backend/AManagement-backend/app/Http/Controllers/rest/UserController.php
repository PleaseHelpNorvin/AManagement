<?php

namespace App\Http\Controllers\rest;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
//libraries
use libphonenumber\PhoneNumberUtil; // Import PhoneNumberUtil class
use libphonenumber\PhoneNumberFormat; // Import PhoneNumberFormat class
//models
use App\Models\User;




class UserController extends ApiController
{
    public function index(Request $request)
    {
        // Retrieve all users with the 'tenant' role
        $tenants = User::where('role', 'tenant')->get();
    
        // Use the custom success response from ApiController
        return $this->successResponse($tenants, 'Tenants retrieved successfully');
    }

    public function show($id)
    {
        // Find the tenant by id
        $tenant = User::find($id);
        
        // If tenant is found, return success response
        if ($tenant) {
            return $this->successResponse($tenant, 'Tenant retrieved successfully');
        }
        
        // If tenant is not found, return error response
        return $this->errorResponse(null, 'Tenant not found', 404);
    }

    public function update($id, Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => ['required', function ($attribute, $value, $fail) {
                $value = preg_replace('/\D/', '', $value); // Remove non-numeric characters
                $phoneUtil = PhoneNumberUtil::getInstance();
                try {
                    $phoneNumber = $phoneUtil->parse($value, 'PH'); // 'PH' for Philippines
                    if (!$phoneUtil->isValidNumber($phoneNumber)) {
                        $fail('The phone number is not valid for the Philippines.');
                    }
                } catch (\libphonenumber\NumberParseException $e) {
                    $fail('The phone number is not valid.');
                }
            }],
            'lease_start' => 'required|date|before_or_equal:lease_end', // Validating lease_start as a date
            'lease_end' => 'required|date|after_or_equal:lease_start',  // Validating lease_end as a date
        ]);
    
        // If validation passes, proceed with the update
        $tenant = User::find($id);
        if ($tenant) {
            $tenant->update($validatedData);
            return $this->successResponse([
                'tenant' => $tenant,
                'lease_period' => [
                    'start' => $tenant->lease_start,
                    'end' => $tenant->lease_end
                ]
            ], 'Tenant updated successfully');
        }
    
        return $this->errorResponse(null, "Tenant with ID {$id} not found", 404);
    }

}