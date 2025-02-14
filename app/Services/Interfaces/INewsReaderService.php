<?php

namespace App\Services\Interfaces;

interface INewsReaderService
{
    public function fetchArticles(): array;
}
