<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;

Route::prefix('v1')->as('api.')->group(function () {
    Route::middleware('throttle:60,1')->group(function () {
        Route::apiResource('appointments', AppointmentController::class);
    });
});
