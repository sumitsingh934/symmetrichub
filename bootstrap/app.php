<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\UserAuth;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\AdminRedirectIfAuthenticated;
use Illuminate\Auth\Middleware\Authenticate;

    return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('admin', [\App\Http\Middleware\VerifyCsrfToken::class]);
        $middleware->appendToGroup('auth', [UserAuth::class]);
        $middleware->appendToGroup('admin', [AdminAuth::class]);
        $middleware->alias([
            'guest' => RedirectIfAuthenticated::class,
            'auth' => Authenticate::class,
            'admin.auth' => AdminAuth::class,
            'guest:admin' => AdminRedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
