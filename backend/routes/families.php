<?php

use App\Family\Infrastructure\Entrypoint\Http\DeleteFamilyByIDController;
use App\Family\Infrastructure\Entrypoint\Http\GetFamiliesByRestaurantController;
use App\Family\Infrastructure\Entrypoint\Http\GetFamilyByIDController;
use App\Family\Infrastructure\Entrypoint\Http\PatchFamilyController;
use App\Family\Infrastructure\Entrypoint\Http\PostFamilyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:user')->group(function () {
    Route::get('/families/restaurant', GetFamiliesByRestaurantController::class);
    Route::get('/families/{id}', GetFamilyByIDController::class);
    Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
        Route::post('/families', PostFamilyController::class);
        Route::delete('/families/{id}', DeleteFamilyByIDController::class);
        Route::patch('/families/{id}', PatchFamilyController::class);
    });
});
