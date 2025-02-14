<?php

namespace App\Jobs;

use App\Repositories\Interfaces\INewsSourceRepository;
use App\Services\Interfaces\INewsReaderService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class FetchNewsFromSourceJob
{
    private const INDEX_CACHE_KEY = "current_news_source_index";

    /**
     * Create a new job instance.
     */
    public function __construct()
    {}

    /**
     * Execute the job.
     */
    public function handle(INewsSourceRepository $newsSourceRepository): void
    {
        $sources = $newsSourceRepository->getListFromCache();
        $reader = $this->getReader($sources);

        if ($reader === null) {
            return;
        }

        $articles = $reader->fetchArticles();


    }

    private function getReader(Collection $sources): INewsReaderService|null
    {
        $count = $sources->count();

        if ($count === 0) {
            return null;
        }

        $currentIndex = Cache::get(self::INDEX_CACHE_KEY, 0);

        if ($count - 1 < $currentIndex) {
            $currentIndex = 0;
        }

        $source = $sources[$currentIndex];

        $readerClass = "App\\Services\\Readers\\{$source->reader_class}";

        if (!class_exists($readerClass)) {
            return null;
        }

        cache()->forever(self::INDEX_CACHE_KEY, $currentIndex + 1);

        return new $readerClass($source);
    }
}
