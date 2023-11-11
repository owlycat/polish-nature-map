<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\RunImporters;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImporterFormRequest;
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
            $availableImporters[] = [
                'name' => (new $importer())->getCategoryName(),
                'class' => $importer,
                'status' => '???',
            ];
        }

        return Inertia::render('Admin/Importers', [
            'availableImporters' => $availableImporters,
        ]);
    }

    public function run(ImporterFormRequest $request): RedirectResponse
    {
        $selectedImporters = $request->validated()['importers'];

        $importers = [];
        foreach ($selectedImporters as $selectedImporter) {
            $importers[] = new $selectedImporter['class']();
        }

        $runImporters = new RunImporters();
        $runImporters->runJobs($importers);

        return back();
    }
}
