<?php

namespace Poyrazenes\AdministrativeCompanyOperations\Providers;

use Illuminate\Support\ServiceProvider;
use Poyrazenes\AdministrativeCompanyOperations\Commands\DestroyWholeApp;

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
            __DIR__.'/../resources/views' => resource_path('views/vendor/adm-comp-ops'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/adm-comp-ops.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adm-comp-ops');

        $this->commands([
            DestroyWholeApp::class
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/adm-comp-ops.php', 'adm-comp-ops'
        );
    }
}
