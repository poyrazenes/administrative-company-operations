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
