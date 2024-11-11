<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $origins = [
            '*' ,
            'http://localhost:51907'
        ];

        $headers = [
            'Access-Control-Allow-Origin' => $origins,  // Adjust as necessary for specific origins
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
            'Access-Control-Allow-Credentials' => 'true'
        ];

        if ($request->getMethod() === 'OPTIONS') {
            return response()->json('OK', 204, $headers);
        }

        $response = $next($request);
        
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
