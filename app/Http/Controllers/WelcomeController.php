<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use App\Models\SpatialFeature;
use App\Models\Category;

class WelcomeController extends Controller
{
    public function index()
    {
        $categoriesWithGeoJSON = Category::all()->map(function ($category) {
            $geojson = SpatialFeature::where('category_id', $category->id)
                ->get()
                ->map(fn($feature) => [
                    'type' => 'Feature',
                    'properties' => ['name' => $feature->name],
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => $feature->_geo
                    ],
                ])
                ->toArray();
        
            return [
                'geojson' => ['type' => 'FeatureCollection', 'features' => $geojson],
                'category' => $category->name,
                'color' => '#' . substr(md5($category->name), 0, 6),
            ];
        })->toArray();

        return Inertia::render('Welcome', [
            'geojson' => $categoriesWithGeoJSON
        ]);
    }
}