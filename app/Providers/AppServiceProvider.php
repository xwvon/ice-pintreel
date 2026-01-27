<?php

namespace App\Providers;

use App\Libraries\JsonResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        //
        $this->app->singleton('j', function () {
            return JsonResponse::getInstance();
        });
        //
        $this->app->singleton('J', function () {
            return JsonResponse::getInstance();
        });
    }
}
