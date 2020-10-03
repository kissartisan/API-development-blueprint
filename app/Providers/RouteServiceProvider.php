<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers\\Api';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->routeGroup(config('app.api.default'));
            $this->routeGroup(config('app.api.stable'));
            $this->routeGroup(config('app.api.latest'));
        });
    }

    private function routeGroup($config)
    {
        Route::group([
            'middleware' => ['api', "api.version:{$config['version']}"],
            'namespace'  => "{$this->namespace}\\{$config['version']}",
            'prefix'     => "api/{$config['url']}",
        ], function ($router) use ($config) {
            require base_path("routes/api/{$config['version']}.php");
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
