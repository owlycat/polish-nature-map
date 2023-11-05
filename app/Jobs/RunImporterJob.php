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
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SpatialFeaturesImporter $importer;

    public function __construct(SpatialFeaturesImporter $importer)
    {
        $this->importer = $importer;
    }

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        $this->importer->run();

        $key = $this->getCacheKey();
        Cache::forget($key);
    }

    public function isRunning(): bool {
        $key = $this->getCacheKey();
        return Cache::has($key);
    }

    public function uniqueId(): string
    {
        return $this->importer->getCategoryName();
    }

    public function getCacheKey(): string {
        return 'RunImporterJob-' . $this->uniqueId();
    }

    public function failed(\Throwable $exception): void
    {
        $key = $this->getCacheKey();
        Cache::forget($key);

        throw $exception;
    }
}
