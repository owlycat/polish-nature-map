<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalMapShareRequest;
use App\Models\Category;
use App\Models\PersonalMap;
use App\Models\SpatialFeature;
use Inertia\Inertia;

class PersonalMapController extends Controller
{
    public function me()
    {
        $user = auth()->user();
        $personalMap = $user->personalMap;

        if (! $personalMap) {
            $personalMap = $user->personalMap()->create([
                'name' => null,
                'is_public' => false,
            ]);
        }

        return Inertia::render('PersonalMap/Show', [
            'personalMap' => $personalMap,
            'displayInfo' => fn () => $this->getDisplayedInformation($user, $personalMap),
        ]);
    }

    public function show(string $name)
    {
        $personalMap = PersonalMap::where('name', $name)->firstOrFail();

        if ($personalMap->user_id == auth()->id()) {
            return redirect()->route('map.me');
        }

        if (! $personalMap->isPublic()) {
            abort(404);
        }

        return Inertia::render('PersonalMap/Show', [
            'personalMap' => $personalMap,
            'displayInfo' => fn () => $this->getDisplayedInformation($personalMap->user, $personalMap),
        ]);
    }

    public function share(PersonalMapShareRequest $request)
    {
        $personalMap = auth()->user()->personalMap;

        $personalMap->update([
            'is_public' => $request->input('privacy.value') === 'public',
            'name' => $request->input('name'),
        ]);
        $personalMap->save();

        return Inertia::location(url()->previous());
    }

    private function countPerCategory($visitedFeatures)
    {
        $categories = Category::all()->map(function ($category) use ($visitedFeatures) {
            $visited = $visitedFeatures->filter(fn ($feature) => $feature->category_id === $category->id)->count();
            $total = SpatialFeature::where('category_id', $category->id)->count();

            return [
                'id' => $category->id,
                'name' => $category->name,
                'visited' => $visited,
                'total' => $total,
            ];
        });

        return $categories;
    }

    private function getDisplayedInformation($user, $personalMap)
    {
        $features = $user->visitedPlaces()->get();
        $categories = $this->countPerCategory($features);
        $allTotals = $categories->sum('total');
        $visitedTotals = $categories->sum('visited');

        $featureCollection = $features->map(fn ($feature) => [
            'type' => 'Feature',
            'properties' => ['id' => $feature->id],
            'id' => $feature->id,
            'geometry' => [
                'type' => 'Point',
                'coordinates' => $feature->_geo,
            ],
        ])
            ->toArray();

        $geojson = ['type' => 'FeatureCollection', 'features' => $featureCollection];

        return [
            'geojson' => $geojson,
            'categories' => $categories,
            'totals' => [
                'visited' => $visitedTotals,
                'all' => $allTotals,
            ],
            'user' => [
                'name' => $user->name,
                'avatar_url' => $user->profile_photo_url,
            ],
        ];
    }
}
