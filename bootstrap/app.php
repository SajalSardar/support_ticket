<?php

use App\Http\Middleware\Localization;
use App\Services\Ticket\AutoCloseTickets;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'locale'             => Localization::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(function () {
            new AutoCloseTickets;
        })->daily();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
