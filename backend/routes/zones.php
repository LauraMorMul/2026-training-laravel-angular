<?php

use App\Zone\Infrastructure\Entrypoint\Http\DeleteZoneByIDController;
use App\Zone\Infrastructure\Entrypoint\Http\GetZoneByIDController;
use App\Zone\Infrastructure\Entrypoint\Http\GetZonesByRestaurantController;
use App\Zone\Infrastructure\Entrypoint\Http\PatchZoneController;
use App\Zone\Infrastructure\Entrypoint\Http\PostZoneController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:user')->group(function () {
    Route::get('/zones/restaurant', GetZonesByRestaurantController::class);
    Route::get('/zones/{id}', GetZoneByIDController::class);
    Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
        Route::post('/zones', PostZoneController::class);
        Route::patch('/zones/{id}', PatchZoneController::class);
        Route::delete('/zones/{id}', DeleteZoneByIDController::class);
    });
});
