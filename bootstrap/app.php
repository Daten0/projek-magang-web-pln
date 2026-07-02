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
        // Trust semua proxy (untuk akses via tunnel/ngrok/dll)
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'role.admin'   => \App\Http\Middleware\RoleAdmin::class,
            'role.mentor'  => \App\Http\Middleware\RoleMentor::class,
            'role.peserta' => \App\Http\Middleware\RolePeserta::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();