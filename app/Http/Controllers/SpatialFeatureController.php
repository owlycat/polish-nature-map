<?php

namespace App\Http\Controllers;

use App\Models\SpatialFeature;

class SpatialFeatureController extends Controller
{
    public function show($id)
    {
        $feature = SpatialFeature::findOrFail($id);

        return $feature;
    }
}