<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use

class PingController extends ApiController
{
    //
    public function ping(Request $request){
        return $this->successResponse([
            'timestamp' => now(),
            'status' => 'Ping Successful',
        ]);
    }
}
