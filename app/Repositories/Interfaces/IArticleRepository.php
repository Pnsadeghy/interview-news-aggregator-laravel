<?php

namespace App\Repositories\Interfaces;

use App\Utils\Interfaces\IResourceRepository;

interface IArticleRepository extends IResourceRepository
{
    public function fullSearch(string $q, array $newsSource, array $categories, array $authors): IArticleRepository;
    public function published(): IArticleRepository;
    public function includesNewsSource(): IArticleRepository;
    public function includesCategories(): IArticleRepository;
    public function includesAuthors(): IArticleRepository;
}
