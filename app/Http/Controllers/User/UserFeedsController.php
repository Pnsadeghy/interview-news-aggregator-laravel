<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\Feed\UserFeedConfigUpdateRequest;
use App\Http\Resources\UserFeed\UserFeedResource;
use App\Repositories\Interfaces\IUserFeedRepository;
use App\Utils\Controllers\ResourceController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group User feeds
 *
 * API endpoints for managing user feeds
 *
 * @authenticated
 */
class UserFeedsController extends ResourceController
{
    public function __construct(IUserFeedRepository $repository) {
        parent::__construct($repository);
    }

    public function show(Request $request): JsonResponse
    {
        $userFeed = $request->user()->defaultFeed;
        $filterData = $this->repository->getFeedNewsFilterData($userFeed);

        return response()->json(
            (new UserFeedResource($userFeed))->additional($filterData)
        );
    }

    /**
     * Update feed config
     *
     * @bodyParam sources array
     * @bodyParam categories array
     * @bodyParam authors array
     *
     * @response 200 {}
     */
    public function updateConfig(UserFeedConfigUpdateRequest $request): JsonResponse
    {
        $userFeed = $request->user()->defaultFeed;

        $this->repository->updateConfig(
            $userFeed,
            [
                "newsSources" => $request->input('sources', []),
                "categories" => $request->input('categories', []),
                "authors" => $request->input('authors', [])
            ]
        );

        return response()->json();
    }
}
