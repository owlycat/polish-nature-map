<?php

namespace App\Http\Controllers\API;

use App\Models\SpatialFeature;
use App\Http\Controllers\Controller;

class SpatialFeatureController extends Controller
{
    public function show($id)
    {
        $feature = SpatialFeature::findOrFail($id);

        return $feature;
    }
}