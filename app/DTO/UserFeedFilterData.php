<?php

namespace App\DTO;

use App\Models\UserFeed;
use App\Models\UserFeedAuthors;
use App\Models\UserFeedCategories;
use App\Models\UserFeedNewsSources;

class UserFeedFilterData
{
    public array $newsSources = [];
    public array $categories = [];
    public array $authors = [];

    public function __construct(UserFeed $userFeed)
    {
        $this->newsSources = UserFeedNewsSources::query()->where('user_feed_id', $userFeed->id)->pluck("news_source_id")->toArray();
        $this->categories = UserFeedCategories::query()->where('user_feed_id', $userFeed->id)->pluck("category_id")->toArray();
        $this->authors = UserFeedAuthors::query()->where('user_feed_id', $userFeed->id)->pluck("author_id")->toArray();
    }
}
