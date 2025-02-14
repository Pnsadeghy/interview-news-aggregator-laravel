<?php

namespace App\Services;

use App\Services\Interfaces\INewsReaderService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class AbstractNewsReaderService implements INewsReaderService
{
    protected string $apiUrl;
    protected string $apiKey;
    protected array $requestData;

    protected string $apiKeyQueryName = "apiKey";

    public function __construct(string $apiUrl, string $apiKey, array $requestData = [])
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->requestData = $requestData;
    }

    abstract public function fetchArticles(): array;

    /**
     * Get http request
     */
    protected function getHttpRequest($query = []): Response
    {
        $query = array_merge($query, $this->requestData);
        $query[$this->apiKeyQueryName] = $this->apiKey;

        return Http::get($this->apiUrl, $query);
    }

    /**
     * Post http request
     */
    protected function postHttpRequest($data = []): Response
    {
        $data = array_merge($data, $this->requestData);
        $data[$this->apiKeyQueryName] = $this->apiKey;

        return Http::post($this->apiUrl, $data);
    }
}
