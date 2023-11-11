<?php

namespace App\Providers;

use App\Importers\LandscapeParkImporter;
use App\Importers\NationalParkImporter;
use Illuminate\Support\ServiceProvider;

class ImportersServiceProvider extends ServiceProvider
{
    private array $importers = [
        NationalParkImporter::class,
        LandscapeParkImporter::class,
    ];

    public function register()
    {
        $this->app->singleton('importer.registry', function ($app) {
            return collect($this->importers);
        });
    }
}
