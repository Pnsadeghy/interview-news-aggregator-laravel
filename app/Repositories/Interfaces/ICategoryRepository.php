<?php

namespace App\Repositories\Interfaces;

use App\Utils\Interfaces\IResourceRepository;

interface ICategoryRepository extends IResourceRepository
{
    public function enabled(): ICategoryRepository;
}
