<?php
namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

class GeojsonFeatureFacade extends Facade
{
     protected static function getFacadeAccessor()
     {
          return GeojsonFeatureFacade::class;
     }
}
