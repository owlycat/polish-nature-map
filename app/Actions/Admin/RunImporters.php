<?php

namespace App\Actions\Admin;

use App\Importers\GeojsonFeaturesImporter;
use App\Jobs\RunImporterJob;

class RunImporters
{
    /**
     * @param  GeojsonFeaturesImporter[]  $geojsonImporters Importers to run
     */
    public function runJobs(array $geojsonImporters): void
    {

        foreach ($geojsonImporters as $importer) {
            RunImporterJob::dispatch($importer);
        }
    }
}
