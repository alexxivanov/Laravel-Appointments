<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', fn () => redirect()->route('appointments.index'));

Route::resource('appointments', AppointmentController::class);
