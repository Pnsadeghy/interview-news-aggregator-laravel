<?php

namespace App\Repositories;

use App\Repositories\Interfaces\INewsSourceRepository;
use App\Utils\Repositories\ResourceRepository;
use App\Models\NewsSource;

class NewsSourceRepository extends ResourceRepository implements INewsSourceRepository
{
    protected string $modelClass = NewsSource::class;
}
