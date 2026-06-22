<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TripPlannerController;
use App\Http\Controllers\Api\MapController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/trip-planner/generate', [TripPlannerController::class, 'generate']);

// Register map markers route
Route::get('/map/markers', [MapController::class, 'markers']);