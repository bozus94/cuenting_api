<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Foundation\Application;
use App\Http\Middleware\testMiddleware;
use App\Http\Middleware\verifyTokenJwt;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: "api/",
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('api/v1/')
                ->name("api.v1")
                ->group(base_path("routes/api/v1_0.php"));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['verify_token' => verifyTokenJwt::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
