<?php

namespace App\Actions\Admin;

use App\Jobs\RunImporterJob;
use App\Importers\GeojsonFeaturesImporter;

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
