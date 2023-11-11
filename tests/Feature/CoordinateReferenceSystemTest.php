<?php

namespace Tests\Feature;

use CRS;
use Tests\TestCase;

class CoordinateReferenceSystemTest extends TestCase
{
    public function test_transform_coordinates(): void
    {
        $result = CRS::transformCoordinates('2180', '4326', [785066.1969983183, 311445.2442906858]);

        $this->assertEquals([23.02987381147266, 50.60027102768133], $result);
    }

    public function test_transform_inverted_coordinates(): void
    {
        $result = CRS::transformCoordinates('2180', '4326', [311445.2442906858, 785066.1969983183], invertSourceCoordinates: true);

        $this->assertEquals([23.02987381147266, 50.60027102768133], $result);
    }
}
