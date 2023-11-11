<?php

namespace App\Jobs;

use App\Importers\GeojsonFeaturesImporter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunImporterJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private GeojsonFeaturesImporter $importer;

    public function __construct(GeojsonFeaturesImporter $importer)
    {
        $this->importer = $importer;
    }

    public function handle(): void
    {
        $this->importer->run();
    }

    public function uniqueId(): string
    {
        return 'RunImporterJob-'.$this->importer->getCategoryName();
    }
}
