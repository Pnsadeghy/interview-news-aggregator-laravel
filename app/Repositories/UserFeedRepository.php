<?php

namespace App\Repositories;

use App\DTO\UserFeedFilterData;
use App\Models\UserFeed;
use App\Models\UserFeedAuthors;
use App\Models\UserFeedCategories;
use App\Models\UserFeedNewsSources;
use App\Repositories\Interfaces\IUserFeedRepository;
use App\Utils\Repositories\ResourceRepository;
use Illuminate\Support\Facades\Cache;

class UserFeedRepository extends ResourceRepository implements IUserFeedRepository
{
    protected string $modelClass = UserFeed::class;

    public function getFeedNewsFilterData(UserFeed $userFeed): UserFeedFilterData
    {
        return Cache::remember(
            $this->getFilterDataCacheKey($userFeed),
            now()->addMinutes(15),
            function () use ($userFeed) {
                return new UserFeedFilterData($userFeed);
            }
        );
    }

    public function updateConfig(UserFeed $userFeed, array $configs): void
    {
        $userFeed->newsSources()->sync($configs["newsSources"]);
        $userFeed->categories()->sync($configs["categories"]);
        $userFeed->authors()->sync($configs["authors"]);
        $this->clearFeedFilterDataCache($userFeed);
    }

    private function clearFeedFilterDataCache(UserFeed $userFeed): void
    {
        Cache::forget($this->getFilterDataCacheKey($userFeed));
    }

    /**
     * Get User feed filter data cache key
     */
    private function getFilterDataCacheKey(UserFeed $userFeed): string
    {
        return "user_feed_filter_data_" . $userFeed->id;
    }
}
