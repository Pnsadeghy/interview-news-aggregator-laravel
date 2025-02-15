<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Feed\UserFeedConfigUpdateRequest;
use App\Http\Resources\UserFeed\UserFeedResource;
use App\Repositories\Interfaces\IUserFeedRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group User feeds
 *
 * API endpoints for managing user feeds
 *
 * @authenticated
 */
class UserFeedsController extends Controller
{
    public function __construct(protected IUserFeedRepository $repository) {}

    /**
     * Get feed
     *
     * @responseFile 200 resources/responses/User/Feed/show.json
     */
    public function show(Request $request): UserFeedResource
    {
        $userFeed = $request->user()->defaultFeed;
        $filterData = $this->repository->getFeedNewsFilterData($userFeed);

        $resource = new UserFeedResource($userFeed);
        $resource->additional([
            'sources' => $filterData->newsSources,
            'categories' => $filterData->categories,
            'authors' => $filterData->authors
        ]);

        return $resource;
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
