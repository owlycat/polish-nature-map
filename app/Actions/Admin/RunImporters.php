<?php

namespace App\Actions\Admin;

use App\Jobs\RunImporterJob;
use App\Importers\SpatialFeaturesImporter;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;
use App\Events\SendMessageEvent;
use Illuminate\Support\Facades\Cache;

class RunImporters {

    /**
     * @param SpatialFeaturesImporter[] $spatialFeaturesImporters Importers to run
     */
    public function runJobs(array $spatialFeaturesImporters): void {
        $user = auth()->user();

        $jobs = [];
        foreach ($spatialFeaturesImporters as $spatialFeaturesImporter) {
            $job = new RunImporterJob($spatialFeaturesImporter);
            if (!$job->isRunning()) {
                $jobs[] = $job;
                $key = $job->getCacheKey();
                Cache::put($key, true, 60);
            }
        }

        $batch = Bus::batch($jobs)
        ->then(function (Batch $batch) use ($user) {
            SendMessageEvent::dispatch($user, 'Success on import.', 'success');
        })->catch(function (Batch $batch, Throwable $e) use ($user) {
            SendMessageEvent::dispatch($user, "Could not finish importing. {$e}", 'error');
            throw $e;
        })->dispatch();

        $totalJobs = $batch->totalJobs;
        if($totalJobs > 0){
            SendMessageEvent::dispatch($user, "Started ${totalJobs} importer job(s).", 'info');
        }
        else{
            SendMessageEvent::dispatch($user, "No importer job(s) to start.", 'warn');
        }
    }
}
