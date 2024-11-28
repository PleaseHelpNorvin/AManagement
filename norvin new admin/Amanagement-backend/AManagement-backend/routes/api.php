<?php

//libraries
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//controllers
use App\Http\Controllers\rest\AuthController;
use App\Http\Controllers\rest\TenantsController;
use App\Http\Controllers\rest\TechniciansController;
use App\Http\Controllers\rest\MessageController;
use App\Http\Controllers\rest\MaintenanceRequestController;
use App\Http\Controllers\rest\PaymentController;

//services
use App\Services\PayMongoService;

    // login route
Route::post('technician/login', [AuthController::class, 'technicianLogin']);
Route::post('tenant/login', [AuthController::class, 'tenantLogin']);
Route::post('admin/login', [AuthController::class, 'adminLogin']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::prefix('tenant')->middleware('auth:sanctum')->group(function () {
    // Tenant Profile
    Route::get('profile/{id}', [TenantsController::class, 'showProfile']);

    // Payment History
    // Route::get('payments', [TenantController::class, 'paymentHistory']);
    Route::post('/generate-payment-link', [PaymentController::class, 'generatePaymentLink']);

    // // Maintenance Requests
    // Route::get('maintenance-requests', [TenantController::class, 'showMaintenanceRequests']);
    // Route::post('maintenance-requests', [TenantController::class, 'createMaintenanceRequest']);

    // // Messaging (Tenant -> Admin only)
    // Route::get('messages', [MessageController::class, 'chatHistory']); // Fetch messages with Admin only
    // Route::post('messages', [MessageController::class, 'sendMessage']); // Tenant to Admin (Only Admin ID allowed)
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    // Tenant 
    Route::get('tenants', [TenantsController::class, 'index']);
    Route::get('tenants/table', [TenantsController::class, 'showTenantsTable']);
    Route::get('tenants/{id}', [TenantsController::class, 'showProfile']);
    Route::put('tenants/{id}', [TenantsController::class, 'update']);

    //Technicians
    Route::get('technicians', [TechniciansController::class, 'index']);
    Route::get('technicians/map', [TechniciansController::class, 'mappedTechnicians']);
    Route::get('technicians/{id}', [TechniciansController::class, 'showProfile']);



    // // Admin to Tenant Messaging (Admin chooses tenant)
    // Route::post('messages/{tenantId}', [MessageController::class, 'sendMessage']); // Admin sends messages to tenants

    // // Payment Management
    // Route::get('payments', [PaymentController::class, 'index']);
    // Route::get('payments/{id}', [PaymentController::class, 'show']);
    // Route::post('payments/report', [PaymentController::class, 'generateReport']);
    // Route::post('payments/{id}/reminder', [PaymentController::class, 'sendReminder']);

    // Maintenance Requests
    Route::get('maintenance-requests', [MaintenanceRequestController::class, 'index']);
    Route::get('maintenance-requests/{id}', [MaintenanceRequestController::class, 'showById']);
    // Route::put('maintenance-requests/{id}', [MaintenanceRequestController::class, 'update']);
});

Route::prefix('technician')->middleware('auth:sanctum')->group(function(){
    //profile related routes
    Route::get('technicians', [TechniciansController::class, 'index']);
    Route::get('profile/{id}', [TechniciansController::class, 'showProfile']);

    //Mainteanance Related Routes
    Route::get('availablerequests', [TechniciansController::class, 'getAllNullMainteRequests']);
    Route::get('myrequests', [TechniciansController::class, 'myAssignedRequests']);
    Route::post('acceptrequests/{id}', [TechniciansController::class, 'acceptRequest']);
});
