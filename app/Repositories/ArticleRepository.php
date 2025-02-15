<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Interfaces\IArticleRepository;
use App\Utils\Repositories\ResourceRepository;
use function Symfony\Component\Translation\t;

class ArticleRepository extends ResourceRepository implements IArticleRepository
{
    protected string $modelClass = Article::class;

    public function fullSearch(string $q, array $newsSource, array $categories, array $authors): IArticleRepository
    {
        if ($q !== "") {
            $this->model = $this->model->whereFullText(['title', 'description', 'body'], $q);
        }

        if (!empty($newsSource)) {
            $this->model = $this->model->whereIn('news_source_id', $newsSource);
        }

        if (!empty($categories)) {
            $this->model = $this->model->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            });
        }

        if (!empty($authors)) {
            $this->model = $this->model->whereHas('authors', function ($query) use ($authors) {
                $query->whereIn('authors.id', $authors);
            });
        }

        return $this;
    }

    public function published(): IArticleRepository
    {
        $this->model = $this->model->published();
        return $this;
    }

    public function includesNewsSource(): IArticleRepository
    {
        $this->model = $this->model->with(["newsSource"]);
        return $this;
    }

    public function includesCategories(): IArticleRepository
    {
        $this->model = $this->model->with(["categories"]);
        return $this;
    }

    public function includesAuthors(): IArticleRepository
    {
        $this->model = $this->model->with(["authors"]);
        return $this;
    }
}
