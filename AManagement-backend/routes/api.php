<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\PingController;
use App\Http\Controllers\UserActivityController;
use App\Http\Middleware\CheckUserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::post('/admin-login',[LoginController::class, 'adminlogin'])->name('adminlogin');
Route::post('/tenant-login', [LoginController::class, 'tenantLogin'])->name('tenantlogin');
Route::post('/tenant-register',[RegisterController::class, 'tenantRegister'])->name('tenenatregister');

Route::middleware('auth:sanctum', 'check.user.activity')->group(function() {
    Route::get('/check-activity', [UserActivityController::class, 'getActivityInfo']); // Adjusted method name
    Route::post('/update-activity', [UserActivityController::class, 'updateActivity']);
    
    Route::post('/logout', [LogoutController::class, 'logout']);

    Route::post('/admin/ping', [PingController::class, 'ping']);

    Route::middleware('user')->group(function() {
        Route::get('/home/user', [HomeController::class, 'userHome']);
        Route::post('/client-info/{userid}', [RegisterController::class, 'updateClientInformation']);

    });
    
    Route::middleware('admin')->group(function() {
        Route::get('/home/admin', [HomeController::class, 'adminHome']);
    });

});


