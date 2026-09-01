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
        // Registro i middleware personalizzati per i ruoli
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'photographer' => \App\Http\Middleware\PhotographerMiddleware::class,
        ]);

        // Stripe invia le notifiche webhook senza token CSRF: la richiesta
        // viene comunque autenticata verificando la firma nel controller
        $middleware->validateCsrfTokens(except: [
            'stripe/webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
