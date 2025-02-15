<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\ArticleAuthor;
use App\Models\ArticleCategory;
use App\Models\Author;
use App\Models\Category;
use App\Models\NewsSource;
use App\Repositories\Interfaces\INewsReaderSourceRepository;
use App\Services\Interfaces\INewsReaderService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FetchNewsFromSourceJob
{
    private const INDEX_CACHE_KEY = "current_news_source_index";

    private INewsReaderService|null  $reader;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {}

    /**
     * Execute the job.
     */
    public function handle(INewsReaderSourceRepository $newsSourceRepository): void
    {
        $sources = $newsSourceRepository->getListFromCache();
        $this->reader = $this->getReader($sources);

        if ($this->reader === null) {
            return;
        }

        $this->generateData();
    }

    /**
     * Get reader class
     */
    private function getReader(Collection $sources): INewsReaderService|null
    {
        $count = $sources->count();

        if ($count === 0) {
            return null;
        }

        $currentIndex = Cache::get(self::INDEX_CACHE_KEY, 0);

        if ($count - 1 < $currentIndex) {
            $currentIndex = 0;
        }

        $source = $sources[$currentIndex];

        $readerClass = "App\\Services\\Readers\\{$source->reader_class}";

        if (!class_exists($readerClass)) {
            return null;
        }

        Cache::forever(self::INDEX_CACHE_KEY, $currentIndex + 1);

        return new $readerClass($source);
    }

    private function generateData(): void
    {
        $articles = $this->reader->fetchArticles();

        if ($articles->isEmpty()) {
            return;
        }

        $this->generateNewsSources($articles);
        $this->generateCategories($articles);

        $newsSourceMap = NewsSource::query()->pluck('id', 'title')->toArray();

        $this->generateAuthors($articles, $newsSourceMap);

        $categoryMap = Category::query()->pluck('id', 'title')->toArray();
        $authorMap = Author::query()->pluck('id', 'name')->toArray();

        $this->generateArticles($articles, $newsSourceMap);

        $articleCategories = collect($articles)->flatMap(function ($article) use ($categoryMap) {
            $articleId = Article::query()->where('url', $article->url)->value('id');
            return collect($article->categories)->map(fn($category) => [
                'article_id' => $articleId,
                'category_id' => $categoryMap[$category],
            ]);
        })->toArray();

        $articleAuthors = collect($articles)->flatMap(function ($article) use ($authorMap) {
            $articleId = Article::query()->where('url', $article->url)->value('id');
            return collect($article->authors)->map(fn($author) => [
                'article_id' => $articleId,
                'author_id' => $authorMap[$author['name']],
            ]);
        })->toArray();

        ArticleCategory::query()->insert($articleCategories);
        ArticleAuthor::query()->insert($articleAuthors);
    }

    private function generateNewsSources(Collection $articles): void
    {
        $newsSources = collect($articles)
            ->map(fn($article) => [
                'title' => $article->sourceTitle,
                'url' => $article->sourceUrl ?? null,
                'is_enabled' => true,
            ])
            ->unique('title')
            ->toArray();

        NewsSource::query()->upsert($newsSources, ['title']);
    }

    private function generateCategories(Collection $articles): void
    {
        $categories = collect($articles)
            ->pluck('categories')
            ->flatten()
            ->unique()
            ->map(fn($title) => ['title' => $title, 'is_enabled' => true])
            ->toArray();

        Category::query()->upsert($categories, ['title']);
    }

    public function generateAuthors(Collection $articles, array $newsSourceMap): void
    {
        $authors = collect($articles)
            ->pluck('authors')
            ->flatten(1)
            ->unique('name')
            ->map(function ($author) use ($newsSourceMap) {
                $newsSourceId = null;

                if ($author["source_title"] && array_key_exists($author["source_title"], $newsSourceMap)) {
                    $newsSourceId = $newsSourceMap[$author["source_title"]];
                }

                return [
                    'news_source_id' => $newsSourceId,
                    'name' => $author['name'],
                    'url' => $author['url'],
                    'is_enabled' => true
                ];
            })
            ->toArray();

        Author::query()->upsert($authors, ['news_source_id', 'name']);
    }

    public function generateArticles(Collection $articles, array $newsSourceMap): void
    {
        $newsReaderSourceId = $this->reader->getSourceID();
        $articlesData = collect($articles)->map(function ($article) use ($newsSourceMap, $newsReaderSourceId) {
            return [
                'news_reader_source_id' => $newsReaderSourceId,
                'news_source_id' => array_key_exists($article->sourceTitle, $newsSourceMap) ? $newsSourceMap[$article->sourceTitle] : null,
                'url' => $article->url,
                'title' => $article->title,
                'slug' => Str::slug($article->title),
                'description' => $article->description,
                'body' => $article->body,
                'published_at' => date('Y-m-d H:i:s', strtotime($article->date)),
                'is_published' => true
            ];
        })->toArray();

        Article::query()->upsert($articlesData, ['url']);
    }
}
