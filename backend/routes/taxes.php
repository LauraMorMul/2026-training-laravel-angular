<?php

use App\Tax\Infrastructure\Entrypoint\Http\DeleteTaxByIDController;
use App\Tax\Infrastructure\Entrypoint\Http\GetTaxByIDController;
use App\Tax\Infrastructure\Entrypoint\Http\GetTaxesbyRestaurantController;
use App\Tax\Infrastructure\Entrypoint\Http\PatchTaxController;
use App\Tax\Infrastructure\Entrypoint\Http\PostTaxControlelr;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:user')->group(function () {
    Route::get('/taxes/restaurant', GetTaxesbyRestaurantController::class);
    Route::get('/taxes/{id}', GetTaxByIDController::class);
    Route::middleware('ability:admin')->group(function () {
        Route::post('/taxes', PostTaxControlelr::class);
        Route::delete('/taxes/{id}', DeleteTaxByIDController::class);
        Route::patch('/taxes/{id}', PatchTaxController::class);
    });
});