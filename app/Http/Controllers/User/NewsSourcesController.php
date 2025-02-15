<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsSource\NewsSourceItemResource;
use App\Repositories\Interfaces\INewsSourceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group News sources
 *
 * API endpoints for managing News sources
 *
 * @authenticated
 */
class NewsSourcesController extends Controller
{
    public function __construct(protected INewsSourceRepository $repository) {}

    /**
     * News sources for user
     *
     * @responseFile 200 resources/responses/User/NewsSource/index.json
     */
    public function index(): JsonResponse
    {
        return response()->json(NewsSourceItemResource::collection($this->repository->enabled()->all()));
    }
}
