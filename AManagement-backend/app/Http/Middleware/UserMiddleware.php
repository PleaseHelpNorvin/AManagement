<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Custom logic to check if the user has access to user routes
        if (!$request->user() || !$request->user()->isUser()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }
        
        return $next($request);
    }
}
