<?php

namespace App\Repositories\Interfaces;

use App\Utils\Interfaces\IResourceRepository;
use Illuminate\Support\Collection;

interface INewsReaderSourceRepository extends IResourceRepository
{
    public function getListFromCache(): Collection;
}
