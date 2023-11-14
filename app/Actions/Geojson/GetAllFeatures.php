<?php

namespace App\Actions\Geojson;

use App\Models\SpatialFeature;

class GetAllFeatures
{
    public function getGeojson(): array
    {
        $featureCollection = SpatialFeature::query()
            ->get()
            ->map(fn ($feature) => [
                'type' => 'Feature',
                'properties' => ['id' => $feature->id],
                'id' => $feature->id,
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => $feature->_geo,
                ],
            ])
            ->toArray();

        return ['type' => 'FeatureCollection', 'features' => $featureCollection];
    }
}
