<?php

namespace App\Providers;

use App\Contracts\Router;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    /** @var string[] */
    private array $routers = [
        \App\Routers\Web\AuthRouter::class,
        \App\Routers\Web\HomeRouter::class,
        \App\Routers\Web\ReplyRouter::class,
        \App\Routers\Web\ThreadRouter::class,
        \App\Routers\Web\UserRouter::class,
    ];

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->loadRoutes();
        });
    }

    protected function loadRoutes(): void
    {
        Route::middleware('web')->group(function () {
            foreach ($this->routers as $router) {
                /** @var Router $classRouter */
                $classRouter = new $router;
                $classRouter->map();
            }
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
