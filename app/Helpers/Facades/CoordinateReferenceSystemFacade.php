<?php

namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

class CoordinateReferenceSystemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CoordinateReferenceSystemFacade::class;
    }
}
