<?php

namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function validateToken(Request $request)
    {
        \Log::info('Token validation request', ['token' => $request->bearerToken()]);
    
        $user = Auth::guard('sanctum')->user();
        \Log::info('Authenticated User', ['user' => $user]);
    
        return response()->json([
            'valid' => $user !== null,
        ]);
    }

}
