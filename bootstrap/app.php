<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            // 'auth' => \App\Http\Middleware\Authenticate::class,
            // 'role' => \App\Http\Middleware\RoleMiddleware::class,
            // 'preventBackHistory' => \App\Http\Middleware\PreventBackHistory::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticatedCustom::class,

            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'talleres/procesandoPago/*',
            'verificar-por-dni/*'
        ]);
        $proxies = env('TRUSTED_PROXIES');

        if ($proxies) {
            $middleware->trustProxies(at: $proxies === '*' ? '*' : explode(',', $proxies));
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
