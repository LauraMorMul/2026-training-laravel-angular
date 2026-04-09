<?php

use App\Families\Infrastructure\Entrypoint\Http\DeleteFamilyByIDController;
use App\Families\Infrastructure\Entrypoint\Http\GetFamiliesByRestaurantController;
use App\Families\Infrastructure\Entrypoint\Http\GetFamilyByIDController;
use App\Families\Infrastructure\Entrypoint\Http\PatchFamilyController;
use App\Families\Infrastructure\Entrypoint\Http\PostFamilyController;
use App\Restaurants\Infrastructure\Entrypoint\Http\PostRestaurantController;
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

//Rutas de familia
Route::post('/families', PostFamilyController::class);
Route::delete('/families/{id}', DeleteFamilyByIDController::class);
Route::get('/families/{id}', GetFamilyByIDController::class);
Route::get('/families/restaurant/{id}', GetFamiliesByRestaurantController::class);
Route::patch('/families/{id}', PatchFamilyController::class);

//Rutas de restaurante
Route::post('/restaurants', PostRestaurantController::class);