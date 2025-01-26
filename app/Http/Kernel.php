<?php
namespace App\Http;
use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // Други глобални middlewares
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Другите middleware...
        'isAdmin' => \App\Http\Middleware\IsAdmin::class,  // Добавете тази линия
    ];
    
    
}
