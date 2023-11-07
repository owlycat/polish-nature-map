<?php

namespace App\Actions\Admin;

use App\Jobs\RunImporterJob;
use App\Importers\GeojsonFeaturesImporter;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;
use App\Events\SendMessageEvent;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Bus\UniqueLock;
use Illuminate\Container\Container;

class RunImporters {

    /**
     * @param GeojsonFeaturesImporter[] $geojsonImporters Importers to run
     */
    public function runJobs(array $geojsonImporters): void {

        foreach ($geojsonImporters as $importer) {
            RunImporterJob::dispatch($importer);
        }
    }
}
