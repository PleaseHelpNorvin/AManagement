<?php

use App\Http\Controllers\rest\ContractController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contracts/{id}', [ContractController::class, 'showContract']);


