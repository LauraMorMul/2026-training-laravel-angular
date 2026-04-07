<?php

use App\User\Infrastructure\Entrypoint\Http\DeleteUserByIDController;
use App\User\Infrastructure\Entrypoint\Http\GetAllUserController;
use App\User\Infrastructure\Entrypoint\Http\GetUserByIDController;
use App\User\Infrastructure\Entrypoint\Http\GetUserByRestaurantController;
use App\User\Infrastructure\Entrypoint\Http\PatchUserController;
use App\User\Infrastructure\Entrypoint\Http\PostUserController;
use Illuminate\Support\Facades\Route;

//Rutas relacionadas con el User
Route::post('/users', PostUserController::class);
Route::get('/users/all', GetAllUserController::class);
Route::get('/users/{id}', GetUserByIDController::class);
Route::get('/users/restaurant/{id}', GetUserByRestaurantController::class);
Route::delete('/users/{id}', DeleteUserByIDController::class);
Route::patch('/users/{id}', PatchUserController::class);