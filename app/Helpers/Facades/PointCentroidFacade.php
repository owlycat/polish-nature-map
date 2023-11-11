<?php

namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

class PointCentroidFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PointCentroidFacade::class;
    }
}
