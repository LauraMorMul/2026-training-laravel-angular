<?php

use App\User\Infrastructure\Entrypoint\Http\DeleteUserByIDController;
use App\User\Infrastructure\Entrypoint\Http\GetUserByIDController;
use App\User\Infrastructure\Entrypoint\Http\GetUserByRestaurantController;
use App\User\Infrastructure\Entrypoint\Http\PatchUserController;
use App\User\Infrastructure\Entrypoint\Http\PostUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:user')->group(function () {
    Route::get('/users/restaurant', GetUserByRestaurantController::class);
    Route::get('/users/{id}', GetUserByIDController::class);
    Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
        Route::post('/users', PostUserController::class);
        Route::patch('/users/{id}', PatchUserController::class);
        Route::delete('/users/{id}', DeleteUserByIDController::class);
    });
});
