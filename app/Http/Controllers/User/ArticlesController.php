<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Article\UserArticleFeedRequest;
use App\Http\Requests\User\Article\UserArticleIndexRequest;
use App\Http\Resources\Article\ArticleItemResource;
use App\Repositories\Interfaces\IArticleRepository;
use App\Repositories\Interfaces\IUserFeedRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group User Articles
 *
 * API endpoints for managing user articles
 *
 * @authenticated
 */
class ArticlesController extends Controller
{
    public function __construct(protected IArticleRepository  $repository,
                                protected IUserFeedRepository $userFeedRepository)
    {
    }

    /**
     * All articles
     *
     * @bodyParam q string
     * @bodyParam page integer
     * @bodyParam per_page integer
     * @bodyParam sources array
     * @bodyParam categories array
     * @bodyParam authors array
     *
     * @responseFile 200 resources/responses/User/Article/index.json
     */
    public function index(UserArticleIndexRequest $request): AnonymousResourceCollection
    {
        return $this->getArticleList(
            $request,
            $request->input("sources", []),
            $request->input("categories", []),
            $request->input("authors", [])
        );
    }

    /**
     * User feed articles
     *
     * @bodyParam q string
     * @bodyParam page integer
     * @bodyParam per_page integer
     *
     * @responseFile 200 resources/responses/User/Article/index.json
     */
    public function feed(UserArticleFeedRequest $request): AnonymousResourceCollection
    {
        $userFeed = $request->user()->defaultFeed;

        $filterData = $this->userFeedRepository->getFeedNewsFilterData($userFeed);

        return $this->getArticleList(
            $request,
            $filterData->newsSources,
            $filterData->categories,
            $filterData->authors
        );
    }

    /**
     * Get articles response
     */
    private function getArticleList(Request $request, array $newsSource, array $categories, array $authors): AnonymousResourceCollection
    {
        $q = $request->string('q');
        $per_page = $request->integer('per_page', config('pagination.per_page'));

        return ArticleItemResource::collection(
            $this->repository->fullSearch($q, $newsSource, $categories, $authors)
                ->published()
                ->includesNewsSource()
                ->includesCategories()
                ->includesAuthors()
                ->paginate($per_page, "published_at", true, [
                    "id", "title", "image_url", "slug", "url", "description", "body", "published_at"
                ])
        );
    }
}
