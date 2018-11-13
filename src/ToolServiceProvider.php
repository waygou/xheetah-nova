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

        Nova::serving(function (ServingNova $event) {
            //
        });

        $this->loadTranslations();

        $this->publishes([
            __DIR__.'/NovaServiceProvider.php.stub'    => base_path('app/Providers/NovaServiceProvider.php'),
            __DIR__.'/../resources/lang/en.json'       => base_path('resources/lang/vendor/nova/en.json'),
            __DIR__.'/../resources/views/overrides'    => base_path('nova/resources/views'),
            __DIR__.'/../config/nova.php'              => config_path('nova.php'),
        ], 'xheetah-nova-overrides');

        $this->publishes([
            __DIR__.'/../resources/lang'            => resource_path('lang/vendor/xheetah-nova'),
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
