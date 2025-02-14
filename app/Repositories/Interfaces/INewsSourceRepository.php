<?php

namespace App\Repositories\Interfaces;

use App\Utils\Interfaces\IResourceRepository;
use Illuminate\Support\Collection;

interface INewsSourceRepository extends IResourceRepository
{
    public function getListFromCache(): Collection;
}
