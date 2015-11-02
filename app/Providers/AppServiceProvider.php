<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('\GuzzleHttp\Client', function($app)
        {
            return new Client;
        });

        // $this->app->singleton('\Lib\Services\GoogleAnalyticsService', function($app)
        // {
        //     return new \Lib\Services\GoogleAnalyticsService;
        // });
    }
}
