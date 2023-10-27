<?php

namespace Poyrazenes\AdministrativeCompanyOperations\Providers;

use Illuminate\Support\ServiceProvider;

class AdministrativeCompanyOperationsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/adm-comp-ops.php' => config_path('adm-comp-ops.php'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/adm-comp-ops.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adm-comp-ops');
    }

    public function register()
    {
        //
    }
}