<?php

namespace App\Repositories;

use App\Models\Author;
use App\Repositories\Interfaces\IAuthorRepository;
use App\Utils\Repositories\ResourceRepository;

class AuthorRepository extends ResourceRepository implements IAuthorRepository
{
    protected string $modelClass = Author::class;


    public function enabled(): IAuthorRepository
    {
        $this->model = $this->model->enabled();
        return $this;
    }
}
