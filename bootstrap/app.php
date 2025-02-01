<?php

use App\Http\Middleware\AdminAlreadyLoggedIn;
use App\Http\Middleware\AdminAuthCheck;
use App\Http\Middleware\RecaptchaMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'recaptcha' => RecaptchaMiddleware::class,
            'adminIsLoggedIn' => AdminAuthCheck::class,
            'adminIsNotLoggedIn' => AdminAlreadyLoggedIn::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            '/notify',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
