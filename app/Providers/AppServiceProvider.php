<?php

namespace App\Providers;

use App\Repositories\Contracts\ActivityRepoInterface;
use App\Repositories\Contracts\AuthRepoInterface;
use App\Repositories\Contracts\BaseRepoInterface;
use App\Repositories\Contracts\DepartmentRepoInterface;
use App\Repositories\Contracts\EmployeeRepoInterface;
use App\Repositories\Eloquent\ActivityRepo;
use App\Repositories\Eloquent\AuthRepo;
use App\Repositories\Eloquent\BaseRepo;
use App\Repositories\Eloquent\DepartmentRepo;
use App\Repositories\Eloquent\EmployeeRepo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepoInterface::class, BaseRepo::class);
        $this->app->bind(AuthRepoInterface::class, AuthRepo::class);
        $this->app->bind(DepartmentRepoInterface::class, DepartmentRepo::class);
        $this->app->bind(EmployeeRepoInterface::class, EmployeeRepo::class);
        $this->app->bind(ActivityRepoInterface::class, ActivityRepo::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
