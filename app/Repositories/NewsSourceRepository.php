<?php

namespace App\Repositories;

use App\Models\NewsSource;
use App\Repositories\Interfaces\INewsSourceRepository;
use App\Utils\Repositories\ResourceRepository;

class NewsSourceRepository extends ResourceRepository implements INewsSourceRepository
{
    protected string $modelClass = NewsSource::class;


    public function enabled(): INewsSourceRepository
    {
        $this->model = $this->model->enabled();
        return $this;
    }
}
