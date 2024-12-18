<?php

use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        //
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'email.verified' => \App\Http\Middleware\CheckEmailVerified::class,
            'owner.verified' => \App\Http\Middleware\CheckOwnerVerify::class,
            'tenant' => \App\Http\Middleware\TenantMiddleware::class,
            'owner' => \App\Http\Middleware\OwnerMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
