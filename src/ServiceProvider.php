<?php

namespace AoScrud;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'ao-scrud');
        $this->loadTranslationsFrom(__DIR__ . '/Resources/langs', 'ao-scrud');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

}
