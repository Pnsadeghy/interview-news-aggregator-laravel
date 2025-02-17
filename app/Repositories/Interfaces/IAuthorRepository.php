<?php

namespace App\Repositories\Interfaces;

use App\Utils\Interfaces\IResourceRepository;

interface IAuthorRepository extends IResourceRepository
{
    public function enabled(): IAuthorRepository;
}
