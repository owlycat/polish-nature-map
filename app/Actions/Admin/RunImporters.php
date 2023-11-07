<?php

namespace App\Actions\Admin;

use App\Jobs\RunImporterJob;
use App\Importers\SpatialFeaturesImporter;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;
use App\Events\SendMessageEvent;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Bus\UniqueLock;
use Illuminate\Container\Container;

class RunImporters {

    /**
     * @param SpatialFeaturesImporter[] $spatialFeaturesImporters Importers to run
     */
    public function runJobs(array $spatialFeaturesImporters): void {
        
        foreach ($spatialFeaturesImporters as $spatialFeaturesImporter) {
            RunImporterJob::dispatch($spatialFeaturesImporter);
        }
    }
}
