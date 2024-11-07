<?php

use App\Http\Controllers\Api\DiagnoseController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('patients', PatientController::class)
    ->except(['show', 'update', 'destroy']);

Route::apiResource('diagnoses', DiagnoseController::class)
    ->except(['show', 'update', 'destroy']);

Route::apiResource('services', ServiceController::class)
    ->except(['show', 'update', 'destroy']);
