<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;

/* middleware */
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\testMiddleware;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\verifyTokenJwt;

/* commands */
use App\Console\Commands\MakeDtoCommand;
use App\Console\Commands\MakeServiceCommand;
use App\Console\Commands\MakeRepositoryCommand;
use App\Console\Commands\MakeRepositoryInterfaceCommand;


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
    })
    ->withCommands([
        MakeDtoCommand::class,
        MakeServiceCommand::class,
        MakeRepositoryCommand::class,
        MakeRepositoryInterfaceCommand::class,

    ])
    ->create();
