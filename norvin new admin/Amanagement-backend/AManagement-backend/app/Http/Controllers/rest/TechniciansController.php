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
        $technicians = User::where('role', 2)->get(); 

        // Return the list of technicians using the successResponse from ApiController
        return $this->successResponse($technicians, 'Technicians fetched successfully');
    }
}
