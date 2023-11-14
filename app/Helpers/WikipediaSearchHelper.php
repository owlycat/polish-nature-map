<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WikipediaSearchHelper
{
    protected $apiUrl = 'https://pl.wikipedia.org/w/api.php';

    protected function performRequest($params)
    {
        return Http::withoutVerifying()->retry(3, 100)
            ->timeout(10)
            ->get($this->apiUrl, $params);
    }

    protected function getExtractByTitle($title)
    {
        $params = [
            'action' => 'query',
            'titles' => $title,
            'format' => 'json',
            'prop' => 'extracts|info',
            'explaintext' => 'true',
            'exintro' => true,
            'inprop' => 'url',
        ];

        $response = $this->performRequest($params);

        $data = json_decode($response->getBody(), true);
        $page = current($data['query']['pages']);

        $extract = isset($page['extract']) ? $page['extract'] : null;
        $fullUrl = isset($page['fullurl']) ? $page['fullurl'] : null;

        return [
            'extract' => $extract,
            'fullurl' => $fullUrl,
        ];
    }

    protected function getSearchResults($query, $limit = 5)
    {
        $params = [
            'action' => 'query',
            'list' => 'search',
            'format' => 'json',
            'srsearch' => $query,
            'srlimit' => $limit,
        ];

        $response = $this->performRequest($params);

        return json_decode($response->getBody(), true);
    }

    protected function findBestMatch($query, $results)
    {
        $bestMatch = null;
        $maxSimilarity = 0;

        foreach ($results as $result) {
            similar_text($result['title'], $query, $similarity);

            if ($similarity >= 90 && $similarity > $maxSimilarity) {
                $maxSimilarity = $similarity;
                $bestMatch = $result;
            }
        }

        return $bestMatch;
    }

    public function query($query): ?array
    {
        $exactMatchData = $this->getExtractByTitle($query);

        if (! empty($exactMatchData['extract'])) {
            return $exactMatchData;
        }

        $searchResults = $this->getSearchResults($query);

        if (empty($searchResults['query']['search'])) {
            return null;
        }

        $bestMatch = $this->findBestMatch($query, $searchResults['query']['search']);

        if ($bestMatch === null) {
            return null;
        }

        $extractData = $this->getExtractByTitle($bestMatch['title']);

        return $extractData;
    }
}
