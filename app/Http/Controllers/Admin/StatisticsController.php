<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SpatialFeature;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class StatisticsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Statistics', [
            'statistics' => $this->getStatistics(),
        ]);
    }

    private function getStatistics(): array
    {
        $importers = app('importer.registry');

        return [
            ['name' => 'Users', 'value' => User::count()],
            ['name' => 'Places', 'value' => SpatialFeature::count()],
            ['name' => 'Categories', 'value' => Category::count()],
            ['name' => 'Importers', 'value' => count($importers)],
        ];
    }
}
