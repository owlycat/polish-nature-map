<?php

namespace App\Http\Controllers;

use App\Actions\Geojson\GetAllFeatures;
use App\Models\Category;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'geojson' => fn () => (new GetAllFeatures())->getGeojson(),
            'categories' => fn () => Category::all(['name', 'id']),
        ]);
    }
}
