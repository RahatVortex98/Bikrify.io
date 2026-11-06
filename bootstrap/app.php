<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

if (PHP_OS_FAMILY === 'Windows' && PHP_SAPI === 'cli') {
    // Preserve the actual Windows environment key casing in Laravel's server subprocess.
    \Illuminate\Foundation\Console\ServeCommand::$passthroughVariables[] = 'SystemRoot';
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
