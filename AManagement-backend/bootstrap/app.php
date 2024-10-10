<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\CorsMiddleware;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias(['cors' => CorsMiddleware::class]);
        $middleware->alias(['admin' => AdminMiddleware::class]);
        $middleware->alias(['user'=> UserMiddleware::class]); // Register UserMiddleware
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        //
        // $exceptions->reportUsing(function ($exception) {
        //     // Custom reporting logic
        // });

        // $exceptions->renderUsing(function ($request, $exception) {
        //     return response()->json(['error' => $exception->getMessage()], $exception->getStatusCode());
        // });
    })->create();
