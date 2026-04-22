<?php

use App\Table\Infrastructure\Entrypoint\Http\DeleteTableByIDController;
use App\Table\Infrastructure\Entrypoint\Http\GetTableByIDController;
use App\Table\Infrastructure\Entrypoint\Http\GetTablesByRestaurantController;
use App\Table\Infrastructure\Entrypoint\Http\PatchTableController;
use App\Table\Infrastructure\Entrypoint\Http\PostTableController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:user')->group(function () {
    Route::get('/tables/restaurant', GetTablesByRestaurantController::class);
    Route::get('/tables/{id}', GetTableByIDController::class);
    Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
        Route::post('/tables', PostTableController::class);
        Route::patch('/tables/{id}', PatchTableController::class);
        Route::delete('/tables/{id}', DeleteTableByIDController::class);
    });
});
