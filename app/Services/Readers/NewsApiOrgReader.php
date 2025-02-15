<?php

namespace App\Services\Readers;

use App\DTO\NewsReaderArticle;
use App\Services\AbstractNewsReaderService;
use Illuminate\Support\Collection;

class NewsApiOrgReader extends AbstractNewsReaderService
{
    public function setValues(): void
    {
        $this->fromDateQueryName = "from";
    }

    public function fetchArticles(): Collection
    {
        return $this->generateArticleList(
            $this->getHttpRequest(),
            "articles",
            function ($article) {
                $sourceTitle = $article['source'] ? $article['source']['name'] : '';

                return new NewsReaderArticle(
                    $article['title'],
                    $article['url'],
                    $article['urlToImage'],
                    $article['description'],
                    $article['content'],
                    $article['publishedAt'],
                    $sourceTitle,
                    "",
                    [],
                    $article["author"] ? array_map(function ($author) use ($sourceTitle) {
                        return [
                          "name" => $author,
                          "url" => "",
                          "source_title" => $sourceTitle
                        ];
                    }, explode(", ", $article["author"])) : []
                );
            }
        );
    }
}
