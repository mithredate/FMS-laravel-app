<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-08-01
 * Time: 11:44 PM
 */

namespace Mithredate\FMSUpdater;


use Illuminate\Support\ServiceProvider;

class FMSUpdaterServiceProvider extends ServiceProvider
{

    public function boot(){
        //Registers package routes
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //Loads FMS Updater views
        $this->loadViewsFrom(__DIR__.'/views', 'fms-updater');

        //Publishes package configurations
        //php artisan vendor:publish --provider="Mithredate\FMSUpdater\FMSUpdaterServiceProvider" --tag=config
        $this->publishes([
            __DIR__.'/config/fms-updater.php' => config_path('fms-updater.php'),
        ], 'config');

        //Publishes package migrations
        //php artisan vendor:publish --provider="Mithredate\FMSUpdater\FMSUpdaterServiceProvider" --tag=migrations
        $this->publishes([
            __DIR__ . '/database/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');

        //Publishes package views
        //php artisan vendor:publish --provider="Mithredate\FMSUpdater\FMSUpdaterServiceProvider" --tag=views
        $this->publishes([
            __DIR__.'/views' => config('view.path') . '/vendor/fms-updater',
        ], 'views');


        //Bind PackageRepositoryContract interface to it's concrete implementation through service container
        $this->app->singleton('Mithredate\FMSUpdater\Contracts\PackageRepositoryContract','Mithredate\FMSUpdater\GitPackageRepositoryBroker');

        //Bind UpdateHandlerContract interface to it's concrete implementation through service container
        $this->app->singleton('Mithredate\FMSUpdater\Contracts\UpdateHandlerContract',function($app){
            return new UpdateHandler($app['Mithredate\FMSUpdater\Contracts\PackageRepositoryContract']);
        });


        //Bind zip facade into the service container
        $this->app->singleton('zip',function($app){
            return new \ZipArchive();
        });
    }
}