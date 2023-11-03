<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\CoordinateReferenceSystemHelper;
use App\Helpers\PointCentroidHelper;
use App\Helpers\Facades\CoordinateReferenceSystemFacade;
use App\Helpers\Facades\PointCentroidFacade;
use Illuminate\Support\Facades\Validator;
use App\Rules\GeometryRule;

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

        $this->app->bind(PointCentroidFacade::class, function(){
            return new PointCentroidHelper();
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
