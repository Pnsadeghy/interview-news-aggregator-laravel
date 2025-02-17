<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Author\AuthorItemResource;
use App\Repositories\Interfaces\IAuthorRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Authors
 *
 * API endpoints for managing Authors
 *
 * @authenticated
 */
class AuthorsController extends Controller
{
    public function __construct(protected IAuthorRepository $repository) {}

    /**
     * Authors for user
     *
     * @responseFile 200 resources/responses/User/Author/index.json
     */
    public function index(): JsonResponse
    {
        return response()->json(AuthorItemResource::collection($this->repository->enabled()->all()));
    }
}
