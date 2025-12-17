<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\Dht22Controller;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// ROUTE AUTOMATIC GET DATA
Route::get('/update-data/{tmp}/{hmd}', [Dht22Controller::class, 'updateData']);
Route::get('/get-data', [Dht22Controller::class, 'getData']);
Route::post('/update-nmax', [Dht22Controller::class, 'updateNilaiMaksimal']);
Route::post('/update-nmin', [Dht22Controller::class, 'updateNilaiMinimal']);

// ROUTE MANUAL LOG REQUEST
Route::post('/trigger-read-sensor', [Dht22Controller::class, 'triggerReadSensor']);
Route::get('/check-read-request', [Dht22Controller::class, 'checkReadRequest']);
Route::get('/get-logs', [Dht22Controller::class, 'getLogs']);

// ROUTE SMART HOME
Route::get('/', [DeviceController::class, 'index']);
Route::post('/devices/toggle/{id}', [DeviceController::class, 'toggle']);
Route::get('/devices/status', [DeviceController::class, 'deviceStatus']);
