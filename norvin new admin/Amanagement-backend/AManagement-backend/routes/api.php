<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\rest\AuthController;
use App\Http\Controllers\rest\TenantsController;
use App\Http\Controllers\rest\MessageController;
use App\Http\Controllers\rest\UserController;
use App\Http\Controllers\rest\PaymentController;
use App\Http\Controllers\rest\MaintenanceRequestController;

// Route::post('login', [AuthController::class, 'login']);
// Route::post('logout', [AuthController::class, 'logout']);

// Tenant login route
Route::post('tenant/login', [AuthController::class, 'tenantLogin']);
// Admin login route
Route::post('admin/login', [AuthController::class, 'adminLogin']);
// Logout route
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::prefix('tenant')->middleware('auth:sanctum')->group(function () {
    // Tenant Profile
    // Route::get('profile', [TenantController::class, 'showProfile']);

    // Payment History
    // Route::get('payments', [TenantController::class, 'paymentHistory']);

    // // Maintenance Requests
    // Route::get('maintenance-requests', [TenantController::class, 'showMaintenanceRequests']);
    // Route::post('maintenance-requests', [TenantController::class, 'createMaintenanceRequest']);

    // // Messaging (Tenant -> Admin only)
    // Route::get('messages', [MessageController::class, 'chatHistory']); // Fetch messages with Admin only
    // Route::post('messages', [MessageController::class, 'sendMessage']); // Tenant to Admin (Only Admin ID allowed)
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    // Tenant Management
    Route::get('tenants', [TenantsController::class, 'index']);
    Route::get('tenants/{id}', [TenantsController::class, 'show']);
    Route::put('tenants/{id}', [TenantsController::class, 'update']);

    // // Admin to Tenant Messaging (Admin chooses tenant)
    // Route::post('messages/{tenantId}', [MessageController::class, 'sendMessage']); // Admin sends messages to tenants

    // // Payment Management
    // Route::get('payments', [PaymentController::class, 'index']);
    // Route::get('payments/{tenantId}', [PaymentController::class, 'show']);
    // Route::post('payments/report', [PaymentController::class, 'generateReport']);
    // Route::post('payments/{tenantId}/reminder', [PaymentController::class, 'sendReminder']);

    // // Maintenance Requests
    // Route::get('maintenance-requests', [MaintenanceRequestController::class, 'index']);
    // Route::get('maintenance-requests/{tenantId}', [MaintenanceRequestController::class, 'show']);
    // Route::put('maintenance-requests/{id}', [MaintenanceRequestController::class, 'update']);
});
