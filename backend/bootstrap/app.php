<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/families.php'));
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/products.php'));
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/taxes.php'));
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/zones.php'));
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/tables.php'));
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/users.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'abilities' => CheckAbilities::class,
            'ability' => CheckForAnyAbility::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(function (Request $request) {
            return $request->is('api/*');
        });
    })->create();
