<?php

use App\Product\Infrastructure\Entrypoint\Http\DeleteProductByIDController;
use App\Product\Infrastructure\Entrypoint\Http\GetProductByIDController;
use App\Product\Infrastructure\Entrypoint\Http\GetProductsByRestaurantController;
use App\Product\Infrastructure\Entrypoint\Http\PatchProductController;
use App\Product\Infrastructure\Entrypoint\Http\PostProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:user')->group(function () {
    Route::get('/products/restaurant', GetProductsByRestaurantController::class);
    Route::get('/products/{id}', GetProductByIDController::class);
    Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
        Route::post('/products', PostProductController::class);
        Route::patch('/products/{id}', PatchProductController::class);
        Route::delete('/products/{id}', DeleteProductByIDController::class);
    });
});
