<?php

namespace App\Actions\Admin;

use App\Importers\GeojsonFeaturesImporter;
use App\Jobs\UpdatePlacesDescriptionsJob;

class UpdateDescriptions
{
    public function runUpdatePlacesDescriptionsJob(): void
    {
        UpdatePlacesDescriptionsJob::dispatch();    
    }
}
