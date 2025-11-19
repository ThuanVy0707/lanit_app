<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.')->group(function () {
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('products', ProductController::class);
});
