<?php

namespace App\Repositories\Interfaces;

use App\DTO\UserFeedFilterData;
use App\Models\UserFeed;
use App\Utils\Interfaces\IResourceRepository;

interface IUserFeedRepository extends IResourceRepository
{
    public function getFeedNewsFilterData(UserFeed $userFeed): UserFeedFilterData;
    public function updateConfig(UserFeed $userFeed, array $configs): void;
}
