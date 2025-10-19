<?php

namespace App\Providers;

use App\Repositories\Contracts\ExpenseCategoryRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EloquentExpenseCategoryRepository;
use App\Repositories\EloquentUserRepository;
use App\Services\AuthService;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\ExpenseCategoryServiceInterface;
use App\Services\ExpenseCategoryService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(ExpenseCategoryServiceInterface::class, ExpenseCategoryService::class);
        $this->app->bind(ExpenseCategoryRepositoryInterface::class, EloquentExpenseCategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
