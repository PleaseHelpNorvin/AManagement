<?php

namespace App\Http\Controllers\pages\tenants;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;

class TenantController extends ApiController
{
    //
    // public function __construct()
    // {
    //     // You can add middleware here if needed (e.g., for authentication).
    // }

    // Method to fetch tenants
   // Method to fetch tenants
   public function getTenants()
   {
       $tenants = User::where('role', 0)->get();
       return $this->successResponse($tenants, 'Tenants fetched successfully');
   }
}
