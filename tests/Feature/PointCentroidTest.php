<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Exceptions\InvalidGeometryException;
use Tests\TestCase;
use PointCentroid;

class PointCentroidTest extends TestCase
{
    public function test_calculate_polygon(): void
    {
        $polygon = [
            'type' => 'Polygon',
            'coordinates' => [
                [
                    [0, 0],
                    [0, 1],
                    [1, 1],
                    [1, 0],
                    [0, 0],
                ],
            ],
        ];

        $result = PointCentroid::calculateFromGeometry($polygon);

        $this->assertEquals([0.5, 0.5], $result);
    }

    public function test_calculate_multipolygon(): void
    {
        $multipolygon = [
            'type' => 'MultiPolygon',
            'coordinates' => [
                [
                    [
                        [0, 0],
                        [0, 1],
                        [1, 1],
                        [1, 0],
                        [0, 0],
                    ],
                    [
                        [2, 2],
                        [2, 3],
                        [3, 3],
                        [3, 2],
                        [2, 2],
                    ],
                ],
            ],
        ];

        $result = PointCentroid::calculateFromGeometry($multipolygon);

        $this->assertEquals([1.5, 1.5], $result);
    }

    public function test_calculate_point(): void
    {
        $point = [
            'type' => 'Point',
            'coordinates' => [0, 0],
        ];

        $result = PointCentroid::calculateFromGeometry($point);

        $this->assertEquals($point["coordinates"], $result);
    }

    public function test_exception_no_geometry(): void
    {
        $this->expectException(InvalidGeometryException::class);
        $result = PointCentroid::calculateFromGeometry([]);
    }

    public function test_exception_no_type(): void
    {
        $this->expectException(InvalidGeometryException::class);
        $result = PointCentroid::calculateFromGeometry(['coordinates' => [0, 0]]);
    }

    public function test_exception_no_coordinates(): void
    {
        $this->expectException(InvalidGeometryException::class);
        $result = PointCentroid::calculateFromGeometry(['type' => 'Point']);
    }

    public function test_exception_invalid_geometry(): void
    {
        $this->expectException(InvalidGeometryException::class);
        $result = PointCentroid::calculateFromGeometry(["invalid geometry"]);
    }
}
