<?php
namespace App\Helpers;

use App\Exceptions\InvalidGeometryException;
use Illuminate\Support\Facades\Validator;
use App\Rules\GeometryRule;
use PointCentroid;
use CRS;

class GeojsonFeatureHelper
{
    public function excludeFeaturesHasPhrase(string $phrase, array $geojson, string $paramName = "name") : array
    {
        $features = $geojson['features'];

        $features = array_filter($features, function($feature) use ($phrase, $paramName) {
            return !str_contains($feature['properties'][$paramName], $phrase);
        });

        return [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];
    }

    public function convertToPoints(array $geojson) : array
    {
        $features = $geojson['features'];

        $features = array_map(function($feature) {
            $geometry = $feature['geometry'];

            $centroid = PointCentroid::calculateFromGeometry($geometry);

            return [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => $centroid,
                ],
                'properties' => $feature['properties'],
            ];
        }, $features);

        return [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];
    }

    public function convertCrs(array $geojson, string $fromCrs, string $toCrs) : array
    {
        $features = $geojson['features'];

        $transformedFeatures = [];
        foreach ($features as $feature) {
            $geometry = $feature['geometry'];

            if ($geometry['type'] === 'Point') {
                list($x, $y) = $geometry['coordinates'];
                list($x2, $y2) = CRS::transformCoordinates($fromCrs, $toCrs, [$x, $y], true);
                $geometry['coordinates'] = [$x2, $y2];
            }

            $transformedFeature = [
                'type' => 'Feature',
                'geometry' => $geometry,
                'properties' => $feature['properties'],
            ];

            $transformedFeatures[] = $transformedFeature;
        }

        $features = $transformedFeatures;

        return [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];
    }

    public function renameProperty(array $geojson, string $oldName, string $newName): array
    {
        $features = &$geojson['features'];
    
        array_walk($features, function (&$feature) use ($oldName, $newName) {
            if (isset($feature['properties'][$oldName])) {
                $feature['properties'][$newName] = $feature['properties'][$oldName];
                unset($feature['properties'][$oldName]);
            }
        });
    
        return [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];
    }
}
