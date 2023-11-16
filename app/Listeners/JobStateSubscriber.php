<?php

namespace App\Listeners;

use App\Enums\ImporterStatuses;
use App\Events\UpdateImporterJobStatus;
use App\Jobs\RunImporterJob;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\Events\JobQueued;
use Illuminate\Support\Facades\Queue;

class JobStateSubscriber
{
    public function handleJobQueued(JobQueued $event): void
    {
        if ($event->job instanceof RunImporterJob) {
            $this->handleRunImporterJob($event->job, ImporterStatuses::QUEUED);
        }
    }

    private function handleRunImporterJob(RunImporterJob $job, ImporterStatuses $status): void
    {
        $importer = $job->getImporter();
        UpdateImporterJobStatus::dispatch($importer, $status);
    }

    /**
     * JobFailed, JobProcessed, JobProcessing don't get fired for queued jobs
     * Queue facade also doesn't work
     */

    /**
     * Register the listeners for the subscriber.
     *
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            JobQueued::class,
            [JobStateSubscriber::class, 'handleJobQueued']
        );
    }
}
