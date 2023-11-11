<?php

namespace App\Helpers;

use App\Exceptions\InvalidGeometryException;
use App\Rules\GeometryRule;
use geoPHP;
use Illuminate\Support\Facades\Validator;

class PointCentroidHelper
{
    /**
     * Calculates the centroid of a geometry.
     *
     * @param  float[]  $geometry The geometry to calculate the centroid for, a property with type and coordinates.
     * @return float[] The centroid of the geometry, represented as an array with two float values.
     */
    public function calculateFromGeometry(array $geometry): array
    {
        $validatorGeometry = Validator::make(['geometry' => $geometry], [
            'geometry' => new GeometryRule,
        ]);

        if ($validatorGeometry->fails()) {
            throw new InvalidGeometryException($validatorGeometry->errors()->first());
        }

        $geometry = GeoPHP::load(json_encode($geometry), 'json');

        $centroid = $geometry->getCentroid();

        return [
            $centroid->getX(),
            $centroid->getY(),
        ];
    }
}
