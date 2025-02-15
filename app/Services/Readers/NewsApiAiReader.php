<?php

namespace App\Services\Readers;

use App\DTO\NewsReaderArticle;
use App\Services\AbstractNewsReaderService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class NewsApiAiReader extends AbstractNewsReaderService
{
    public function setValues(): void
    {
        $this->fromDateQueryName = "dateStart";
    }

    public function fetchArticles(): Collection
    {
        $query = [
            'action' => 'getArticles',
            'resultType' => 'articles',
            'articlesCount' => 20
        ];

        return $this->generateArticleList(
            $this->postHttpRequest($query),
            "articles.results",
            function ($article) {
                $sourceTitle = "";
                $sourceUrl = "";
                $categories = [];

                if ($article['source']) {
                    $sourceTitle = $article['source']['title'];
                    $sourceUrl = $article['source']['uri'];
                    if ($article['source']['dataType']) {
                        $categories = [$article['source']['dataType']];
                    }
                }

                $authors = array_map(function ($author) use ($sourceTitle, $sourceUrl) {
                    return [
                        "name" => $author['name'],
                        "url" => $author['uri'],
                        "source_title" => $sourceTitle
                    ];
                }, $article['authors']);

                return new NewsReaderArticle(
                    $article['title'],
                    $article['url'],
                    $article['image'],
                    Str::limit($article['body'], 250),
                    $article['body'],
                    $article['dateTimePub'],
                    $sourceTitle,
                    $sourceUrl,
                    $categories,
                    $authors
                );
            }
        );
    }
}
