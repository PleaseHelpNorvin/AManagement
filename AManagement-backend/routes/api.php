<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\PingController;
use App\Http\Controllers\UserActivityController;
use App\Http\Middleware\CheckUserActivity;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//tenantsimports
use App\Http\Controllers\pages\tenants\TenantController;

// Authentication routes
Route::post('/admin-login',[LoginController::class, 'adminlogin']);
Route::post('/tenant-login', [LoginController::class, 'tenantLogin']);
Route::post('/tenant-register',[RegisterController::class, 'tenantRegister']);


Route::middleware('auth:sanctum', 'check.activity')->group(function() {
    Route::get('/check-activity', [UserActivityController::class, 'getActivityInfo']); // Adjusted method name
    Route::post('/update-activity', [UserActivityController::class, 'updateActivity']);
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::post('/admin/ping', [PingController::class, 'ping']);

    //chat related route
    Route::post('/send-message', [ChatController::class, 'message']);

    Route::middleware('user')->group(function() {
        Route::get('/home/user', [HomeController::class, 'userHome']);
        Route::post('/client-info/{userid}', [RegisterController::class, 'updateClientInformation']);

    });
    
    Route::middleware('admin')->group(function() {
        Route::get('/home/admin', [HomeController::class, 'adminHome']);
        //for fetching tenants data //Display,edit,and delete
        Route::get('/admin/tenants', [TenantController::class, 'getTenants']);
        Route::get('/admin/tenants/{tenantId}', [TenantController::class, 'getTenantById']);
        Route::put('/admin/tenants/update/{tenantId}', [TenantController::class, 'updateTenant']);
        Route::delete('/admin/tenants/delete/{tenantId}', [TenantController::class, 'deleteTenantById']);
        //
    });
});


