<?php

use App\User\Infrastructure\Entrypoint\Http\DeleteByIDController;
use App\User\Infrastructure\Entrypoint\Http\GetAllController;
use App\User\Infrastructure\Entrypoint\Http\GetByIDController;
use App\User\Infrastructure\Entrypoint\Http\GetByRestaurantController;
use App\User\Infrastructure\Entrypoint\Http\PostController;
use Illuminate\Support\Facades\Route;


//Rutas relacionadas con el User
Route::post('/users', PostController::class);
Route::get('/users/all', GetAllController::class);
Route::get('/user/{id}', GetByIDController::class);
Route::get('/users/restaurant/{id}', GetByRestaurantController::class);
Route::delete('/user/{id}', DeleteByIDController::class);
