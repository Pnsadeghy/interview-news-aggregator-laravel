<?php

namespace App\Repositories;

use App\Repositories\Interfaces\INewsSourceRepository;
use App\Utils\Repositories\ResourceRepository;
use App\Models\NewsSource;
use Illuminate\Support\Collection;

class NewsSourceRepository extends ResourceRepository implements INewsSourceRepository
{
    protected string $modelClass = NewsSource::class;
    private const CACHE_KEY = 'news-sources';

    public function getListFromCache(): Collection
    {
        return cache()->rememberForever(self::CACHE_KEY, function () {
            return $this->model->active()->get();
        });
    }
}
