<?php

use App\Order\Infrastructure\Entrypoint\Http\GetOrderAndLinesByTableController;
use App\Order\Infrastructure\Entrypoint\Http\PatchOrPostOrderLinesController;
use App\Order\Infrastructure\Entrypoint\Http\PostOrderWithLinesController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:user')->group(function () {
    Route::post('/order', PostOrderWithLinesController::class);
    Route::patch('/order_lines', PatchOrPostOrderLinesController::class);
    Route::get('/order/table/{id}', GetOrderAndLinesByTableController::class);
});
