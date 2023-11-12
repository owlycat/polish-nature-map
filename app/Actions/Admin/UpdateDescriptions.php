<?php

namespace App\Actions\Admin;

use App\Jobs\UpdatePlacesDescriptionsJob;

class UpdateDescriptions
{
    public function runUpdatePlacesDescriptionsJob(): void
    {
        UpdatePlacesDescriptionsJob::dispatch();
    }
}
