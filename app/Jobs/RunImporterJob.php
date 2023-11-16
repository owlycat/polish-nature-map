<?php

namespace App\Jobs;

use App\Enums\ImporterStatuses;
use App\Events\UpdateImporterJobStatus;
use App\Importers\GeojsonFeaturesImporter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

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
        UpdateImporterJobStatus::dispatch($this->importer, ImporterStatuses::RUNNING);
        $this->importer->run();
        UpdateImporterJobStatus::dispatch($this->importer, ImporterStatuses::SUCCESS);
    }

    public function getImporter(): GeojsonFeaturesImporter
    {
        return $this->importer;
    }

    public function uniqueId(): string
    {
        return 'RunImporterJob-'.$this->importer->getCategoryName();
    }

    public function failed(Throwable $exception): void
    {
        UpdateImporterJobStatus::dispatch($this->importer, ImporterStatuses::FAILED);
    }
}
