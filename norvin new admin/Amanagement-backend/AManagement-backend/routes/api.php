<?php

//libraries
use Illuminate\Http\Request;
use App\Services\PayMongoService;

//controllers
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\rest\AuthController;
use App\Http\Controllers\rest\RoomController;
use App\Http\Controllers\rest\MessageController;
use App\Http\Controllers\rest\PaymentController;
use App\Http\Controllers\rest\TenantsController;
use App\Http\Controllers\rest\ContractController;
use App\Http\Controllers\rest\TechniciansController;
// use App\Http\Controllers\rest\ContractController;

// TenantController

//services
use App\Http\Controllers\rest\TenantRegisterController;
use App\Http\Controllers\rest\ContractSettingController;
use App\Http\Controllers\rest\MaintenanceRequestController;

    // login route
Route::post('technician/login', [AuthController::class, 'technicianLogin']);
Route::post('tenant/login', [AuthController::class, 'tenantLogin']);
Route::post('admin/login', [AuthController::class, 'adminLogin']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    //register user
Route::post('tenant/register', [TenantsController::class, 'createTenantUser']);

Route::prefix('tenant')->middleware('auth:sanctum')->group(function () {
    // tenant 
    Route::post('create-tenant',[TenantsController::class,'createTenantRecord']);
    Route::post('create-profile', [TenantsController:: class, 'createTenantUserProfile']);
    Route::get('profile/{userId}', [TenantsController::class, 'getUserProfile']);

    //Contracts routes
    Route::post('contracts/create', [ContractController::class, 'createContract']);
    Route::get('contracts/{contractId}/generate', [ContractController::class, 'generateContract']);
    Route::get('contracts/{tenantId}', [ContractController::class, 'showContract']);
    Route::get('contracts', [ContractController::class, 'getContract']);

    //Properties / Rooms
    Route::get('properties', [RoomController::class, 'showProperties']);
    Route::get('room/{property_id}', [RoomController::class, 'showRoomsByPropertyId']);

    // Payment History
    // Route::get('payments', [TenantController::class, 'paymentHistory']);
    Route::post('payments/generate-payment-link', [PaymentController::class, 'generatePaymentLink']);

    // Maintenance Requests
    // Route::get('maintenance-requests/show', [TenantController::class, 'showMaintenanceRequests']);
    Route::post('maintenance-requests', [TenantsController::class, 'createMaintenanceRequest']);

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

    //contract settings for making the admin can set a 1 data only intended for adding customized 
    /*
    {
        "success": true,
        "message": "Success",
        "data": {
            "id": 1,
            "late_fee_percentage": 5.00,
            "security_deposit_percentage": 50.00,
            "created_at": "2024-12-03T00:00:00.000000Z",
            "updated_at": "2024-12-03T00:00:00.000000Z"
        }
    },
    {
        "success": true,
        "message": "Contract settings updated successfully.",
        "data": {
            "id": 1,
            "late_fee_percentage": 7.00,
            "security_deposit_percentage": 60.00,
            "created_at": "2024-12-03T00:00:00.000000Z",
            "updated_at": "2024-12-03T00:00:00.000000Z"
        }
            only the next the admin can only update that data
    } */
    // Route::put('/contract-settings', [ContractSettingsController::class, 'updateContractSettings']);
    Route::get('contract-settings/', [ContractSettingController::class, 'index']); // View current settings
    Route::post('contract-settings/', [ContractSettingController::class, 'store']); // Create or update settings
    Route::post('contract-settings/calculate', [ContractSettingController::class, 'calculate']); // Calculate percentages

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
