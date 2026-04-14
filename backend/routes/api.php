<?php

use App\Families\Infrastructure\Entrypoint\Http\DeleteFamilyByIDController;
use App\Families\Infrastructure\Entrypoint\Http\GetFamiliesByRestaurantController;
use App\Families\Infrastructure\Entrypoint\Http\GetFamilyByIDController;
use App\Families\Infrastructure\Entrypoint\Http\PatchFamilyController;
use App\Families\Infrastructure\Entrypoint\Http\PostFamilyController;
use App\Products\Infrastructure\Entrypoint\Http\DeleteProductByIDController;
use App\Products\Infrastructure\Entrypoint\Http\GetProductByIDController;
use App\Products\Infrastructure\Entrypoint\Http\GetProductsByRestaurantController;
use App\Products\Infrastructure\Entrypoint\Http\PatchProductController;
use App\Products\Infrastructure\Entrypoint\Http\PostProductController;
use App\Restaurants\Infrastructure\Entrypoint\Http\PostRestaurantController;
use App\Taxes\Infrastructure\Entrypoint\Http\DeleteTaxByIDController;
use App\Taxes\Infrastructure\Entrypoint\Http\GetTaxByIDController;
use App\Taxes\Infrastructure\Entrypoint\Http\GetTaxesbyRestaurantController;
use App\Taxes\Infrastructure\Entrypoint\Http\PatchTaxController;
use App\Taxes\Infrastructure\Entrypoint\Http\PostTaxControlelr;
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

//Rutas de tax
Route::post('/taxes', PostTaxControlelr::class);
Route::delete('/taxes/{id}', DeleteTaxByIDController::class);
Route::get('/taxes/{id}', GetTaxByIDController::class);
Route::get('/taxes/restaurant/{id}', GetTaxesbyRestaurantController::class);
Route::patch('/taxes/{id}', PatchTaxController::class);

//Rutas de product
Route::post('/products', PostProductController::class);
Route::get('/products/{id}', GetProductByIDController::class);
Route::get('/products/restaurant/{id}', GetProductsByRestaurantController::class);
Route::patch('/products/{id}', PatchProductController::class);
Route::delete('/products/{id}', DeleteProductByIDController::class);