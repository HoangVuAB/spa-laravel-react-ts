<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected array $repositories = [
        'User',
    ];

    protected string $repositoryPath = 'App\Repositories';

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        foreach ($this->repositories as $repository) {
            app()->singleton(
                "{$this->repositoryPath}\\$repository\\{$repository}RepositoryInterface",
                "{$this->repositoryPath}\\$repository\\{$repository}Repository",
            );
        }
    }
}
