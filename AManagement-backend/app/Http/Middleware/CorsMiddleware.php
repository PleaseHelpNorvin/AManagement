<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->getMethod() === 'OPTIONS') {
            return response()->json('OK', 204, $this->getCorsHeaders());
        }

        return $next($request)->withHeaders($this->getCorsHeaders());
    }
 
    /**
     * Get the CORS headers to include in the response.
     *
     * @return array
     */
    
     protected function getCorsHeaders(): array
     {
        // return [
        //     'paths' => ['api/*'],
        //     'allowed_methods' => ['*'], // Allow all HTTP methods (GET, POST, PUT, DELETE, etc.)
        //     'allowed_origins' => ['*'], // Allow all origins
        //     'allowed_headers' => ['*'], // Allow all headers
        //     'exposed_headers' => [],
        //     'max_age' => 0,
        //     'supports_credentials' => true,
        // ];
        // return [
             $response = $next($request);
             $response->headers->set('Access-Control-Allow-Origin', '*'); // Change '*' to your specific front-end URL for security
             $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
             $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
             $response->headers->set('Access-Control-Allow-Credentials', 'true');
        // ];

        return $response;
     }
}
