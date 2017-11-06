<?php

namespace Thiru\Mpesa;

use Illuminate\Support\ServiceProvider;
use Thiru\Mpesa\B2C\B2CInterface;
use Thiru\Mpesa\B2C\B2C;
use Thiru\Mpesa\C2B\C2BInterface;
use Thiru\Mpesa\C2B\C2B;

class MpesaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {


        $this->publishes([__DIR__.'/Config/mpesa.php'=>config_path('mpesa.php')], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Config

        $this->mergeConfigFrom( __DIR__ . '/Config/mpesa.php','mpesa');
//        $this->app['mpesa'] = $this->app->singleton(function($app) {
//            return new Mpesa;
//        });
//        $this->app->bind(['mpesa' =>Mpesa::class], function () {
//            // Do something here
//            return new Mpesa();
//        });
        $this->app->alias(\Illuminate\Support\Str::class, 'Mpesa');

    }

}
