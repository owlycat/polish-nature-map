<?php

namespace App\Providers;

use App\Helpers\CoordinateReferenceSystemHelper;
use App\Helpers\Facades\CoordinateReferenceSystemFacade;
use App\Helpers\Facades\GeojsonFeatureFacade;
use App\Helpers\Facades\PointCentroidFacade;
use App\Helpers\GeojsonFeatureHelper;
use App\Helpers\PointCentroidHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (config('telescope.enabled')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->bind(CoordinateReferenceSystemFacade::class, function () {
            return new CoordinateReferenceSystemHelper();
        });

        $this->app->bind(PointCentroidFacade::class, function () {
            return new PointCentroidHelper();
        });

        $this->app->bind(GeojsonFeatureFacade::class, function () {
            return new GeojsonFeatureHelper();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::globalRequestMiddleware(fn ($request) => $request->withHeader(
            'User-Agent', config('app.name').'/'.config('app.version', '1.0.0'),
        ));
    }
}
