<?php

namespace Waygou\XheetahNova;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Waygou\XheetahNova\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'xheetah-nova');

        $this->app->booted(function () {
            $this->routes();
        });

        $this->loadTranslations();

        Nova::serving(function (ServingNova $event) {
            Nova::style('xheetah-nova-theme', __DIR__.'/../resources/css/theme.css');
        });

        $this->publishes([
            __DIR__.'/../resources/img/'      => public_path('vendor/xheetah/'),
            __DIR__.'/../resources/partials/' => resource_path('views/vendor/nova/partials/'),
        ], 'xheetah-nova-theme-overrides');

        $this->publishes([
            __DIR__.'/NovaServiceProvider.php.stub'    => base_path('app/Providers/NovaServiceProvider.php'),
            __DIR__.'/../resources/lang/en.json'       => base_path('resources/lang/vendor/nova/en.json'),
            __DIR__.'/../resources/views/overrides/'   => base_path('nova/resources/views/'),
            __DIR__.'/../config/nova.php'              => config_path('nova.php'),
        ], 'xheetah-nova-overrides');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/xheetah-nova'),
        ], 'xheetah-nova-translations');
    }

    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(resource_path('lang/vendor/xheetah-nova'), 'xheetah-nova');
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/xheetah-nova')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
