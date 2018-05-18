<?php

namespace App\Providers;

use App\Libs\ShopifyCurl;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ShopifyCurl::class, function( Application $app ){
           return new ShopifyCurl();
        });
    }
}
