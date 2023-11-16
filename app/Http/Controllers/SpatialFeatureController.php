<?php

namespace App\Http\Controllers;

use App\Models\SpatialFeature;
use App\Models\User;

class SpatialFeatureController extends Controller
{
    public function show($id)
    {
        $feature = SpatialFeature::findOrFail($id);

        $feature->load(['category' => function ($query) {
            $query->select('id', 'display_name', 'image');
        }]);

        return $feature;
    }

    public function search()
    {
        $filters = $this->getInputs(request());
        $user = auth()->user();

        $results = $this->searchFeatures($filters)->paginate(20);

        $results->setCollection($results->getCollection()->load('category')->map(function ($item) use ($user) {
            return [
                'id' => $item->id,
                'category_name' => $item->category->name,
                'category_display_name' => $item->category->display_name,
                'category_image' => $item->category->image,
                'name' => $item->name,
                'visited' => $user ? $user->hasVisited($item->id) : false,
            ];
        }));

        return $results;
    }

    public function filterIds()
    {
        $filters = $this->getInputs(request());

        if ($this->hasNoFilters($filters)) {
            return SpatialFeature::all()->pluck('id');
        } else {
            if (isset($filters['query']) && $filters['query'] !== '') {
                return $this->getAllIdsFromScout($filters);
            } else {
                return $this->eloquentSearch($filters)->pluck('id');
            }
        }
    }

    /**
     * Meilisearch has a limit of 1000 results per query.
     * We will chunk the results to get all the ids.
     */
    private function getAllIdsFromScout($filters)
    {
        $ids = [];
        $page = 1;
        $perPage = 20;
        $hasMore = true;

        while ($hasMore) {
            $results = $this->scoutSearch($filters)->paginate($perPage, 'id', $page);
            $ids = array_merge($ids, $results->pluck('id')->toArray());

            if ($results->hasMorePages()) {
                $page++;
            } else {
                $hasMore = false;
            }
        }

        return $ids;
    }

    private function searchFeatures($filters)
    {
        if (isset($filters['query']) && $filters['query'] !== '') {
            return $this->scoutSearch($filters);
        } else {
            return $this->eloquentSearch($filters);
        }
    }

    private function scoutSearch($filters)
    {
        $search = $filters['query'];
        $categories = $filters['categories'];
        $visited = $filters['visited'];
        $results = SpatialFeature::search($search);

        if (! empty($categories)) {
            $categoryNames = array_column($categories, 'name');
            $results->whereIn('category', $categoryNames);
        }

        if (! auth()->user()) {
            return $results;
        }

        if ($visited === 'visited') {
            $userId = auth()->id();
            $visitedPlaceIds = User::find($userId)->visitedPlaces()->pluck('spatial_features.id')->toArray();
            $results->whereIn('id', $visitedPlaceIds);
        } elseif ($visited === 'not_visited') {
            $userId = auth()->id();
            $visitedPlaceIds = User::find($userId)->visitedPlaces()->pluck('spatial_features.id')->toArray();
            $results->whereNotIn('id', $visitedPlaceIds);
        }

        return $results;
    }

    private function eloquentSearch($filters)
    {
        $categories = $filters['categories'];
        $visited = $filters['visited'];
        $query = SpatialFeature::query();

        if (! empty($categories)) {
            $categoryIds = array_column($categories, 'id');
            $query->whereHas('category', function ($query) use ($categoryIds) {
                $query->whereIn('id', $categoryIds);
            });
        }

        if (! auth()->user()) {
            return $query;
        }

        if ($visited === 'visited') {
            $query->whereHas('visitors', function ($query) {
                $query->where('user_id', auth()->id());
            });
        } elseif ($visited === 'not_visited') {
            $query->whereDoesntHave('visitors', function ($query) {
                $query->where('user_id', auth()->id());
            });
        }

        return $query;
    }

    private function hasNoFilters($filters)
    {
        return empty($filters['query']) && empty($filters['categories']) && $filters['visited'] === 'all';
    }

    private function getInputs($request)
    {
        return [
            'query' => $request->input('query') ?? '',
            'categories' => $request->input('categories') ?? [],
            'visited' => $request->input('visited') ?? 'all',
        ];
    }
}
