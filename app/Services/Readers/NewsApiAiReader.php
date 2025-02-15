<?php

namespace App\Services\Readers;

use App\Services\AbstractNewsReaderService;
use Illuminate\Support\Facades\Log;

class NewsApiAiReader extends AbstractNewsReaderService
{
    public function fetchArticles(): array
    {
        #TODO Add dateStart query (get date from cache) to ignores previously read news
        $query = [
            'action' => 'getArticles',
            'resultType' => 'articles',
            'articlesCount' => 20
        ];

        $response = $this->postHttpRequest($query);

        if (!$response->successful()) {
            Log::error(json_encode($response->json()));
            return [];
        }

        $articles = $response->json('articles');
        #TODO add lastNews date in cache

        Log::debug("NewsApi.ai Articles fetched: " . count($articles));

        return $articles;
    }
}
