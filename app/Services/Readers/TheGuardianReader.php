<?php

namespace App\Services\Readers;

use App\DTO\NewsReaderArticle;
use App\Services\AbstractNewsReaderService;
use Illuminate\Support\Collection;

class TheGuardianReader extends AbstractNewsReaderService
{

    public function setValues(): void
    {
        $this->apiKeyQueryName = "api-key";
        $this->fromDateQueryName = "from-date";
    }

    public function fetchArticles(): Collection
    {
        return $this->generateArticleList(
            $this->getHttpRequest(),
            "response.results",
            function ($article) {
                return new NewsReaderArticle(
                    $article['webTitle'],
                    $article['webUrl'],
                    "",
                    "",
                    "",
                    $article['webPublicationDate'],
                    "The Guardian",
                    "https://www.theguardian.com/",
                    [$article["sectionName"]],
                    []
                );
            }
        );
    }
}
