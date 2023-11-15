<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SpatialFeature;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Statistics', [
            'statistics' => $this->getStatistics(),
        ]);
    }

    private function statistic(string $name, $value): array
    {
        return ['name' => $name, 'value' => $value];
    }

    public function getMostVisitedPlace()
    {
        $place = SpatialFeature::withCount('visitors')
            ->orderBy('visitors_count', 'desc')
            ->first();
    
        return "{$place->name}, {$place->visitors_count}";
    }

    private function getStatistics(): array
    {
        $importers = app('importer.registry');

        return [
            $this->statistic('Users', User::count()),
            $this->statistic('Places', SpatialFeature::count()),
            $this->statistic('Places with descriptions', SpatialFeature::whereNotNull('description')->count()),
            $this->statistic('Categories', Category::count()),
            $this->statistic('Importers', count($importers)),
            $this->statistic('All visits', DB::table('visited_places')->count()),
            $this->statistic('Visits today', DB::table('visited_places')->whereDate('created_at', today())->count()),
            $this->statistic('Most visited place', $this->getMostVisitedPlace()),
        ];
    }
}
