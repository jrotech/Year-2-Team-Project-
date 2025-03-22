<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\LogRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Temporarily disable CSRF for Artillery testing
       /* $middleware->validateCsrfTokens(except: [
            'login',
            'register',
            'api/*',
            'basket/*',
            'checkout',
        ]);
        */
        $middleware->append(LogRequests::class);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
