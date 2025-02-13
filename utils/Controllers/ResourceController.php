<?php

namespace Utils\Controllers;

use App\Http\Controllers\Controller;
use Utils\Interfaces\IResourceRepository;

class ResourceController extends Controller
{
    protected ?IResourceRepository $repository;

    public function __construct(IResourceRepository $repository = null)
    {
        $this->repository = $repository;
    }
}
