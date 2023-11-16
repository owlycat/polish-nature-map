<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\RunImporters;
use App\Actions\Admin\UpdateDescriptions;
use App\Http\Controllers\Controller;
use App\Models\ImporterStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ImporterController extends Controller
{
    public function index(Request $request): Response
    {
        $availableImporters = [];
        $importers = app('importer.registry');

        foreach ($importers as $importer) {
            $importerStatus = ImporterStatus::where('job_name', $importer)->latest()->first();
            $status = 'not_run';
            $timestamp = 'Never';

            if ($importerStatus) {
                $status = $importerStatus->job_status;
                $timestamp = $importerStatus->job_timestamp;
            }

            $availableImporters[] = [
                'name' => (new $importer())->getCategoryName(),
                'class' => $importer,
                'status' => $status,
                'timestamp' => $timestamp,
            ];
        }

        $importerStatuses = ImporterStatus::orderBy('job_timestamp', 'desc')->take(20)->get();

        return Inertia::render('Admin/Importers', [
            'availableImporters' => $availableImporters,
            'statuses' => $importerStatuses,
        ]);
    }

    public function run(Request $request): RedirectResponse
    {
        $importer = $request->input('importer');
        $runImporters = new RunImporters();
        $runImporters->runJobs([new $importer['class']()]);

        return back();
    }

    public function runAll(): RedirectResponse
    {
        $importers = app('importer.registry');

        $importerInstances = [];
        foreach ($importers as $importerClass) {
            $importerInstances[] = new $importerClass();
        }

        $runImporters = new RunImporters();
        $runImporters->runJobs($importerInstances);

        return back();
    }

    public function updatePlacesDescriptions(): RedirectResponse
    {
        $updateDescriptions = new UpdateDescriptions();
        $updateDescriptions->runUpdatePlacesDescriptionsJob();

        return back();
    }
}
