<?php

namespace AntControl\Providers;

use Illuminate\Support\ServiceProvider;

class JQueryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([base_path('vendor/components/jquery') => public_path('vendor/jquery')],'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
