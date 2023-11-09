<?php
namespace App\Helpers;

use geoPHP;
use App\Exceptions\InvalidGeometryException;
use Illuminate\Support\Facades\Validator;
use App\Rules\GeometryRule;

class PointCentroidHelper
{
    /**
     * Calculates the centroid of a geometry.
     *
     * @param float[] $geometry The geometry to calculate the centroid for, a property with type and coordinates.
     * @return float[] The centroid of the geometry, represented as an array with two float values.
     */
    function calculateFromGeometry(array $geometry) : array{
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
