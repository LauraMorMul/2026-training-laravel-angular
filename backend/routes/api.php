<?php

use App\User\Infrastructure\Entrypoint\Http\GetAllController;
use App\User\Infrastructure\Entrypoint\Http\GetByIDController;
use App\User\Infrastructure\Entrypoint\Http\PostController;
use Illuminate\Support\Facades\Route;

Route::post('/users', PostController::class);
Route::get('/users/all', GetAllController::class);
Route::get('/user/{id}', GetByIDController::class);