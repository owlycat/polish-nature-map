<?php

namespace App\Http\Controllers\API;

use App\Models\SpatialFeature;
use App\Http\Controllers\Controller;

class SpatialFeatureController extends Controller
{
    public function show($id)
    {
        $feature = SpatialFeature::findOrFail($id);

        return $feature;
    }

    public function search(){
        $query = request()->input('query') ?? '';

        $results = SpatialFeature::search($query)->paginate(20);

        $results->setCollection($results->getCollection()->load('category')->map(function ($item) {
            return [
                'id' => $item->id,
                'category_name' => $item->category->name,
                'name' => $item->name,
            ];
        }));

        return $results;
    }

    public function filterIds()
    {
        $query = request()->input('query') ?? '';

        $featureCollection = $query === ''
            ? SpatialFeature::all()
            : SpatialFeature::search($query)->take(1000)->get();

        $featureIds = $featureCollection->map(fn ($feature) => $feature->id)->toArray();

        return $featureIds;
    }
}
