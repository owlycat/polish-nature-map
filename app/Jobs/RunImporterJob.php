<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Importers\SpatialFeaturesImporter;
use Illuminate\Support\Facades\Cache;
use Throwable;

class RunImporterJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SpatialFeaturesImporter $importer;

    public function __construct(SpatialFeaturesImporter $importer)
    {
        $this->importer = $importer;
    }

    public function handle(): void
    {
        $this->importer->run();
    }

    public function uniqueId(): string
    {
        return "RunImporterJob-" . $this->importer->getCategoryName();
    }
}
