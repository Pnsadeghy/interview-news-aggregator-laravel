<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryItemResource;
use App\Repositories\Interfaces\ICategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Categories
 *
 * API endpoints for managing Categories
 *
 * @authenticated
 */
class CategoriesController extends Controller
{
    public function __construct(protected ICategoryRepository $repository) {}

    /**
     * Categories for user
     *
     * @responseFile 200 resources/responses/User/Category/index.json
     */
    public function index(): JsonResponse
    {
        return response()->json(CategoryItemResource::collection($this->repository->enabled()->all()));
    }
}
