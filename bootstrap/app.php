<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register custom authentication middleware aliases
        $middleware->alias([
            'auth.umkm' => \App\Http\Middleware\EnsureUmkmAuthenticated::class,
            'auth.admin' => \App\Http\Middleware\EnsureAdminAuthenticated::class,
            'auth.umkm.or.admin' => \App\Http\Middleware\EnsureUmkmOrAdminAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
