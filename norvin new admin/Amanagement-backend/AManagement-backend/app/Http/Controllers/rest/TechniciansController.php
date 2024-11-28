<?php

namespace App\Http\Controllers\rest;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\User;


class TechniciansController extends ApiController
{
    //
    public function index()
    {   
        // Assuming role 2 represents technicians
        $technicians = User::with([
            'tenants',
            'contracts',
            'maintenanceRequests',
            'messagesSent',
            'messagesReceived',
            'notifications',
        ])->where('role', 'technician')->get(); 

        // Return the list of technicians using the successResponse from ApiController
        return $this->successResponse($technicians, 'Technicians fetched successfully');
    }

    public function showProfile($technicianId)
    {
        $technician = User::with([
            'tenants',
            'contracts',
            'maintenanceRequests',
            'messagesSent',
            'messagesReceived',
            'notifications',
        ])->where('id', $technicianId)->where('role', 'technician')->get(); 

        // Check if the technicians exists
        if (!$technician) {
            return $this->errorResponse('Technician not found', 404);
        }

        return $this->successResponse($technician, 'Technician Profile Retrieved Successfully');
    }
}
