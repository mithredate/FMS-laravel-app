<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-08-01
 * Time: 11:44 PM
 */

namespace Mithredate\FMS;


use Illuminate\Support\ServiceProvider;

class FMSServiceProvider extends ServiceProvider
{

    public function boot(){
        require __DIR__.'/../vendor/autoload.php';
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
        // TODO: Implement register() method.
    }
}