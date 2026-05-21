<?php

use App\Restaurant\Infrastructure\Entrypoint\Http\LoginRestaurantController;
use App\Restaurant\Infrastructure\Entrypoint\Http\PostRestaurantController;
use App\User\Infrastructure\Entrypoint\Http\GetUserByRestaurantController;
use App\User\Infrastructure\Entrypoint\Http\LoginUserController;
use App\User\Infrastructure\Entrypoint\Http\LoginUserPinController;
use Illuminate\Support\Facades\Route;

Route::post('/context', LoginRestaurantController::class);

Route::middleware('auth:restaurant')->group(function () {
    Route::post('/login', LoginUserController::class);
    Route::post('/login-pin', LoginUserPinController::class);
    Route::get('/users/restaurant', GetUserByRestaurantController::class);
});

Route::post('/restaurants', PostRestaurantController::class);
