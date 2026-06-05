<?php

use App\Sale\Infrastructure\Entrypoint\Http\PostSaleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:user')->group(function () {
    Route::post('/sale', PostSaleController::class);
});
