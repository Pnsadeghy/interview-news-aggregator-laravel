<?php

namespace App\Services;

abstract class AbstractReaderService
{
    protected string $apiUrl;
    protected string $apiKey;

    public function __construct(string $apiUrl, string $apiKey)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
    }

    abstract public function fetchArticles(): array;
}
