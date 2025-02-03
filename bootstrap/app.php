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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_superadmin' => \App\Http\Middleware\isSuperAdminRole::class,
            'isEmploye' => \App\Http\Middleware\isEmploye::class,
            'is_adminAndAssistant' => \App\Http\Middleware\is_adminAndAssistant::class,
            'isAdminAndHr' => \App\Http\Middleware\isAdminAndHr::class,
            'isEmployeActive' => \App\Http\Middleware\isEmployeActive::class,

            // $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();