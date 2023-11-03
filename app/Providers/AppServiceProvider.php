<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\CoordinateReferenceSystemHelper;
use App\Helpers\Facades\CoordinateReferenceSystemFacade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CoordinateReferenceSystemFacade::class, function(){
            return new CoordinateReferenceSystemHelper();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
