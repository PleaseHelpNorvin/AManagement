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
         return [
             'Access-Control-Allow-Origin' => '*',
             'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
             'Access-Control-Allow-Headers' => 'X-Requested-With, Content-Type, Authorization',
         ];
     }
}
