<?php

namespace App\Http\Controllers;

use App\Models\SpatialFeature;

class VisitsController extends Controller
{
    public function visit($placeId)
    {
        $place = SpatialFeature::find($placeId);

        if (! $place) {
            return response()->json(['message' => 'Place not found', 'severity' => 'info', 'title' => 'Info'], 404);
        }

        $user = auth()->user();
        $visitors = $place->visitors()->get();

        if ($visitors->contains($user->id)) {
            return response()->json(['message' => 'You have already visited this place', 'severity' => 'info', 'title' => 'Info'], 200);
        }

        $place->visitors()->attach($user->id);

        return response()->json(['message' => 'Place visited successfully', 'severity' => 'success', 'title' => 'Success'], 200);
    }

    public function unvisit($placeId)
    {
        $place = SpatialFeature::find($placeId);

        if (! $place) {
            return response()->json(['message' => 'Place not found', 'severity' => 'success', 'title' => 'Info'], 404);
        }

        $user = auth()->user();
        $place->visitors()->detach($user->id);

        return response()->json(['message' => 'Place unvisited successfully', 'severity' => 'info', 'title' => 'Info'], 200);
    }
}
