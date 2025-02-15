<?php

namespace App\Repositories;

use App\Repositories\Interfaces\INewsReaderSourceRepository;
use App\Utils\Repositories\ResourceRepository;
use App\Models\NewsReaderSource;
use Illuminate\Support\Collection;

class NewsReaderSourceRepository extends ResourceRepository implements INewsReaderSourceRepository
{
    protected string $modelClass = NewsReaderSource::class;
    private const CACHE_KEY = 'news-reader-sources';

    public function getListFromCache(): Collection
    {
        return cache()->rememberForever(self::CACHE_KEY, function () {
            return $this->model->enabled()->get();
        });
    }
}
