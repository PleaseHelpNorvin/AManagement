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
    public function handle(Request $request, Closure $next): Response
    {
        // $origins = [
        //     '*'
        // ];

        // Get the origin of the incoming request
        $origin = $request->headers->get('Origin');

        // Set the headers to allow the valid origin
        $headers = [
            'paths' => ['api/*'],
        'allowed_methods' => ['*'],  // Allows all HTTP methods like GET, POST, etc.
        'allowed_origins' => ['*'], // Allow only your frontend domain
        'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization'], // Specify allowed headers
        'exposed_headers' => [],
        'max_age' => 0,
        'supports_credentials' => true, // Set to true if you need credentials (like cookies, authorization headers)
        ];

        if ($request->getMethod() === 'OPTIONS') {
            return response()->json('OK', 200, $headers);
        }

        $response = $next($request);

        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
