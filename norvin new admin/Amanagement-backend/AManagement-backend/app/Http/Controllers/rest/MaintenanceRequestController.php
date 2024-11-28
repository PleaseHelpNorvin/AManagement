<?php

namespace App\Http\Controllers\rest;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Models\User;

class MaintenanceRequestController extends ApiController
{
    //
    public function index()
    {
        $maintenancerequest = MaintenanceRequest::with(['tenant','property'])->get();

        return $this->successResponse($maintenancerequest, 'Maintenance Requests Fetched Successfully');
    }

    public function showById($maintenanceId)
    {
        $maintenancerequest = MaintenanceRequest::with(['tenant','property'])
        ->where('id', $maintenanceId)->first();

        

        return $this->successResponse($maintenancerequest, 'Maintenance Fetched By Id Successfully');
    }

    

}
