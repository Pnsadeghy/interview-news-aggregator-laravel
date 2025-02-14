<?php

namespace App\Services\Readers;

use App\Services\AbstractNewsReaderService;
use Illuminate\Support\Facades\Log;

class TheGuardianReader extends AbstractNewsReaderService
{

    public function fetchArticles(): array
    {
        $this->apiKeyQueryName = "api-key";

        #TODO Add from-date query (get date from cache) to ignores previously read news
        $query = [];

        $response = $this->getHttpRequest($query);

        if (!$response->successful()) {
            Log::error(json_encode($response->json()));
            return [];
        }

        $articles = $response->json('response.results');
        #TODO add lastNews date in cache

        Log::info("TheGuardian.com Articles fetched: " . count($articles));

        return [];
    }
}
