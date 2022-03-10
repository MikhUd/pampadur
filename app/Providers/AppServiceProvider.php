<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserRole;
use App\Repositories\Interfaces\UserRepositoryContract;
use App\Repositories\Interfaces\UserRoleRepositoryContract;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use App\Services\Auth\AuthService;
use App\Services\DatingCardService;
use App\Services\Interfaces\AuthServiceContract;
use App\Services\Interfaces\DatingCardServiceContract;
use App\Services\Interfaces\UserServiceContract;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AuthServiceContract::class, AuthService::class);

        $this->app->bind(UserRepositoryContract::class, function () {
            return new UserRepository(new User());
        });

        $this->app->bind(UserRoleRepositoryContract::class, function () {
            return new UserRoleRepository(new UserRole());
        });

        $this->app->bind(UserServiceContract::class, UserService::class);

        $this->app->bind(DatingCardServiceContract::class, DatingCardService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
