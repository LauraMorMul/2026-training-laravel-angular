<?php

use App\Family\Infrastructure\Entrypoint\Http\DeleteFamilyByIDController;
use App\Family\Infrastructure\Entrypoint\Http\GetFamiliesByRestaurantController;
use App\Family\Infrastructure\Entrypoint\Http\GetFamilyByIDController;
use App\Family\Infrastructure\Entrypoint\Http\PatchFamilyController;
use App\Family\Infrastructure\Entrypoint\Http\PostFamilyController;
use App\Product\Infrastructure\Entrypoint\Http\DeleteProductByIDController;
use App\Product\Infrastructure\Entrypoint\Http\GetProductByIDController;
use App\Product\Infrastructure\Entrypoint\Http\GetProductsByRestaurantController;
use App\Product\Infrastructure\Entrypoint\Http\PatchProductController;
use App\Product\Infrastructure\Entrypoint\Http\PostProductController;
use App\Restaurant\Infrastructure\Entrypoint\Http\LoginRestaurantController;
use App\Restaurant\Infrastructure\Entrypoint\Http\PostRestaurantController;
use App\Table\Infrastructure\Entrypoint\Http\DeleteTableByIDController;
use App\Table\Infrastructure\Entrypoint\Http\GetTableByIDController;
use App\Table\Infrastructure\Entrypoint\Http\GetTablesByRestaurantController;
use App\Table\Infrastructure\Entrypoint\Http\PatchTableController;
use App\Table\Infrastructure\Entrypoint\Http\PostTableController;
use App\Tax\Infrastructure\Entrypoint\Http\DeleteTaxByIDController;
use App\Tax\Infrastructure\Entrypoint\Http\GetTaxByIDController;
use App\Tax\Infrastructure\Entrypoint\Http\GetTaxesbyRestaurantController;
use App\Tax\Infrastructure\Entrypoint\Http\PatchTaxController;
use App\Tax\Infrastructure\Entrypoint\Http\PostTaxControlelr;
use App\User\Infrastructure\Entrypoint\Http\DeleteUserByIDController;
use App\User\Infrastructure\Entrypoint\Http\GetAllUserController;
use App\User\Infrastructure\Entrypoint\Http\GetUserByIDController;
use App\User\Infrastructure\Entrypoint\Http\GetUserByRestaurantController;
use App\User\Infrastructure\Entrypoint\Http\LoginUserController;
use App\User\Infrastructure\Entrypoint\Http\PatchUserController;
use App\User\Infrastructure\Entrypoint\Http\PostUserController;
use App\Zone\Infrastructure\Entrypoint\Http\DeleteZoneByIDController;
use App\Zone\Infrastructure\Entrypoint\Http\GetZoneByIDController;
use App\Zone\Infrastructure\Entrypoint\Http\GetZonesByRestaurantController;
use App\Zone\Infrastructure\Entrypoint\Http\PatchZoneController;
use App\Zone\Infrastructure\Entrypoint\Http\PostZoneController;
use Illuminate\Support\Facades\Route;

Route::post('/context', LoginRestaurantController::class);

Route::middleware('auth:restaurant')->group(function () {
    Route::post('/login', LoginUserController::class);
    Route::get('/families/restaurant', GetFamiliesByRestaurantController::class);
});

Route::middleware('auth:user')->group(function () {
    Route::get('/families/{id}', GetFamilyByIDController::class);
    Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
        Route::post('/users', PostUserController::class);
        Route::post('/families', PostFamilyController::class);
        Route::delete('/families/{id}', DeleteFamilyByIDController::class);
        Route::patch('/families/{id}', PatchFamilyController::class);
    });
});

// Rutas relacionadas con el User

Route::get('/users/all', GetAllUserController::class);
Route::get('/users/{id}', GetUserByIDController::class);
Route::get('/users/restaurant/{id}', GetUserByRestaurantController::class);
Route::delete('/users/{id}', DeleteUserByIDController::class);
Route::patch('/users/{id}', PatchUserController::class);

// Rutas de familia






// Rutas de restaurante
Route::post('/restaurants', PostRestaurantController::class);

// Rutas de tax
Route::post('/taxes', PostTaxControlelr::class);
Route::delete('/taxes/{id}', DeleteTaxByIDController::class);
Route::get('/taxes/{id}', GetTaxByIDController::class);
Route::get('/taxes/restaurant/{id}', GetTaxesbyRestaurantController::class);
Route::patch('/taxes/{id}', PatchTaxController::class);

// Rutas de product
Route::post('/products', PostProductController::class);
Route::get('/products/{id}', GetProductByIDController::class);
Route::get('/products/restaurant/{id}', GetProductsByRestaurantController::class);
Route::patch('/products/{id}', PatchProductController::class);
Route::delete('/products/{id}', DeleteProductByIDController::class);

// Rutas de zones
Route::post('/zones', PostZoneController::class);
Route::get('/zones/{id}', GetZoneByIDController::class);
Route::get('/zones/restaurant/{id}', GetZonesByRestaurantController::class);
Route::patch('/zones/{id}', PatchZoneController::class);
Route::delete('/zones/{id}', DeleteZoneByIDController::class);

// Rutas de tables
Route::post('/tables', PostTableController::class);
Route::get('/tables/{id}', GetTableByIDController::class);
Route::get('/tables/restaurant/{id}', GetTablesByRestaurantController::class);
Route::patch('/tables/{id}', PatchTableController::class);
Route::delete('/tables/{id}', DeleteTableByIDController::class);
