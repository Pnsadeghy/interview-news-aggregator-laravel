<?php

namespace App\Providers;

use App\Repositories\Interfaces\INewsSourceRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\NewsSourceRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppRepositoriesProvider extends ServiceProvider
{
    protected array $repositoryBindings = [
        IUserRepository::class => UserRepository::class,
        INewsSourceRepository::class => NewsSourceRepository::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        foreach ($this->repositoryBindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
