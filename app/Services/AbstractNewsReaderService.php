<?php

namespace App\Services;

use App\Models\NewsSource;
use App\Services\Interfaces\INewsReaderService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class AbstractNewsReaderService implements INewsReaderService
{
    private string $apiUrl;
    private string $apiKey;
    private array $requestData;

    protected string $apiKeyQueryName = "apiKey";

    public function __construct(NewsSource $source)
    {
        $this->apiUrl = $source->api_url;
        $this->apiKey = $source->api_key;
        $this->requestData = $source->request_data;
    }

    abstract public function fetchArticles(): array;

    /**
     * Get http request
     */
    protected function getHttpRequest($query = []): Response
    {
        return Http::get($this->apiUrl, $this->getRequestData($query));
    }

    /**
     * Post http request
     */
    protected function postHttpRequest($data = []): Response
    {
        return Http::post($this->apiUrl, $this->getRequestData($data));
    }

    /**
     * Get request data
     */
    private function getRequestData(array $data): array
    {
        $data = array_merge($data, $this->requestData);
        $data[$this->apiKeyQueryName] = $this->apiKey;
        return $data;
    }
}
