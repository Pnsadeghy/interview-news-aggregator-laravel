<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Utils\Repositories\ResourceRepository;

class CategoryRepository extends ResourceRepository implements ICategoryRepository
{
    protected string $modelClass = Category::class;


    public function enabled(): ICategoryRepository
    {
        $this->model = $this->model->enabled();
        return $this;
    }
}
