<?php

namespace App\Services;

use App\Models\NewsReaderSource;
use App\Services\Interfaces\INewsReaderService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

abstract class AbstractNewsReaderService implements INewsReaderService
{
    public const DATE_CACHE_KEY = "news_source_date_";

    protected string $apiKeyQueryName = "apiKey";
    protected string $fromDateQueryName = "";

    private string $newsReaderSourceId;
    private string $apiUrl;
    private string $apiKey;
    private array $requestData;

    private string $dateCacheKey = "";

    public function __construct(NewsReaderSource $source)
    {
        $this->newsReaderSourceId = $source->id;
        $this->apiUrl = $source->api_url;
        $this->apiKey = $source->api_key;
        $this->requestData = $source->request_data;
        $this->dateCacheKey = self::DATE_CACHE_KEY . $source->id;
        $this->setValues();
    }

    abstract public function setValues(): void;
    abstract public function fetchArticles(): Collection;

    public function getSourceID(): string
    {
        return $this->newsReaderSourceId;
    }

    /**
     * Get http request
     */
    protected function getHttpRequest($query = []): Response
    {
        $response = Http::get($this->apiUrl, $this->getRequestData($query));
        $this->checkResponse($response);
        return $response;
    }

    /**
     * Post http request
     */
    protected function postHttpRequest($data = []): Response
    {
        $response = Http::post($this->apiUrl, $this->getRequestData($data));
        $this->checkResponse($response);
        return $response;
    }

    /**
     * Generate article list
     */
    protected function generateArticleList(Response $response, string $articleKey, $convertor): Collection
    {
        if (!$response->successful()) {
            return collect([]);
        }

        return collect($response->json($articleKey))->map($convertor);
    }

    /**
     * Get request data
     */
    private function getRequestData(array $data): array
    {
        $data = array_merge($data, $this->requestData);
        $data[$this->apiKeyQueryName] = $this->apiKey;
        if ($this->fromDateQueryName != "") {
            $cachedDate = Cache::get($this->dateCacheKey);
            if ($cachedDate) {
                $data[$this->fromDateQueryName] = $cachedDate;
            }
        }
        return $data;
    }

    /**
     * Check response
     */
    private function checkResponse(Response $response): void
    {
        if ($response->successful()) {
            Cache::forever($this->dateCacheKey, now());
        } else {
            Log::error($response->json());
        }
    }
}
