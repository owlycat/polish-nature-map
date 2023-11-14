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

    public function search()
    {
        $filters = $this->getInputs(request());
        $user = auth()->user();

        $results = $this->searchFeatures($filters)->paginate(20);

        $results->setCollection($results->getCollection()->load('category')->map(function ($item) use ($user) {
            return [
                'id' => $item->id,
                'category_name' => $item->category->name,
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

        $results = SpatialFeature::search($search);

        if (! empty($categories)) {
            $categoryNames = array_column($categories, 'name');
            $results->whereIn('category', $categoryNames);
        }

        return $results;
    }

    private function eloquentSearch($filters)
    {
        $categories = $filters['categories'];
        $query = SpatialFeature::query();

        if (! empty($categories)) {
            $categoryIds = array_column($categories, 'id');
            $query->whereHas('category', function ($query) use ($categoryIds) {
                $query->whereIn('id', $categoryIds);
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
