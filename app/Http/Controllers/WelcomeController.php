<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SpatialFeature;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index()
    {
        $features = SpatialFeature::paginate(20);

        return Inertia::render('Welcome', [
            'geojson' => fn () => $this->getGeojson(),
            'features' => $features,
        ]);
    }


    private function getGeojson(): array{
        $featureCollection = SpatialFeature::query()
                ->get()
                ->map(fn ($feature) => [
                    'type' => 'Feature',
                    'properties' => ['name' => $feature->id],
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => $feature->_geo,
                    ],
                ])
                ->toArray();

        return ['type' => 'FeatureCollection', 'features' => $featureCollection];
    }
}
