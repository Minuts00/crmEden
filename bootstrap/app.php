<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        then: function ($app) {
            $router = $app->make(\Illuminate\Routing\Router::class);
            $router->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        return [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
        ];
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();