<?php

namespace App\Helpers;

use proj4php\Point;
use proj4php\Proj;
use proj4php\Proj4php;

class CoordinateReferenceSystemHelper
{
    private Proj4php $proj4;

    public function __construct()
    {
        $this->proj4 = new Proj4php();
    }

    /**
     * Transforms a point from one coordinate system to another.
     *
     * @param  string  $from The source coordinate system.
     * @param  string  $to The target coordinate system.
     * @param  float[]  $point The point to transform, represented as an array with two float values.
     * @param  bool  $invertSourceCoordinates Whether to invert the source coordinates.
     * @return float[] The transformed point, represented as an array with two float values.
     */
    public function transformCoordinates(string $from, string $to, array $point, bool $invertSourceCoordinates = false): array
    {
        if ($invertSourceCoordinates) {
            $point = [$point[1], $point[0]];
        }

        $p = $this->proj4->transform(
            new Proj('EPSG:'.$from, $this->proj4),
            new Proj('EPSG:'.$to, $this->proj4),
            new Point($point[0], $point[1])
        );

        return [$p->x, $p->y];
    }
}
