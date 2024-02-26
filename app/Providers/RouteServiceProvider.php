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
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'auth', 'role:super_admin'])
                ->prefix('super_admin')
                ->as('super_admin.')
                ->group(base_path('routes/super_admin.php'));

            Route::middleware(['web', 'auth', 'role:admin'])
                ->prefix('admin')
                ->as('admin.')
                ->group(base_path('routes/admin.php'));

            Route::middleware(['web', 'auth', 'role:doctor'])
                ->prefix('doctor')
                ->as('doctor.')
                ->group(base_path('routes/doctor.php'));

            Route::middleware(['web', 'auth', 'role:lab'])
                ->prefix('lab')
                ->as('lab.')
                ->group(base_path('routes/lab.php'));

            Route::middleware(['web', 'auth', 'role:external_lab'])
                ->prefix('external_lab')
                ->as('lab.')
                ->group(base_path('routes/external_lab.php'));
        });
    }
}
