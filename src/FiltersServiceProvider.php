<?php

namespace Alvarium\Filters;


use Illuminate\Support\ServiceProvider;

class FiltersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Services\Filters\Filters', function() {
            return new Filters();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/' => config_path() . '/']);

        $this->publishes([__DIR__ . '/../app/' => app_path() . '/']);
    }
}
