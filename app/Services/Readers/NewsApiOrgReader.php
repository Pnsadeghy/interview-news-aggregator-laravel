<?php

namespace App\Services\Readers;

use App\Services\AbstractNewsReaderService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsApiOrgReader extends AbstractNewsReaderService
{
    public function fetchArticles(): array
    {
        #TODO Add from query (get date from cache) to ignores previously read news
        $query = [];

        $response = $this->getHttpRequest($query);

        if (!$response->successful()) {
            Log::error(json_encode($response->json()));
            return [];
        }

        $articles = $response->json('articles');
        #TODO add lastNews date in cache

        Log::info("NewsApi.org Articles fetched: " . count($articles));

        return [];
    }
}
