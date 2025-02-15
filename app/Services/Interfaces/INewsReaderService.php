<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface INewsReaderService
{
    public function fetchArticles(): Collection;

    public function getSourceID(): string;
}
