<?php

namespace App\Providers;

use App\Models\DatingCard;
use App\Models\Like;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserRole;
use App\Repositories\DatingCardRepository;
use App\Repositories\FilterRepository;
use App\Repositories\Interfaces\DatingCardRepositoryContract;
use App\Repositories\Interfaces\FilterRepositoryContract;
use App\Repositories\Interfaces\LikeRepositoryContract;
use App\Repositories\Interfaces\TagRepositoryContract;
use App\Repositories\Interfaces\UserRepositoryContract;
use App\Repositories\Interfaces\UserRoleRepositoryContract;
use App\Repositories\LikeRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use App\Services\AuthService;
use App\Services\DatingCardService;
use App\Services\ImageService;
use App\Services\Interfaces\AuthServiceContract;
use App\Services\Interfaces\DatingCardServiceContract;
use App\Services\Interfaces\ImageServiceContract;
use App\Services\Interfaces\LikeServiceContract;
use App\Services\Interfaces\PrivateFilesServiceContract;
use App\Services\Interfaces\TagSynchronizerContract;
use App\Services\Interfaces\UserServiceContract;
use App\Services\LikeService;
use App\Services\PrivateFilesService;
use App\Services\TagSynchronizer;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, function () {
            return new UserRepository(new User());
        });

        $this->app->bind(UserRoleRepositoryContract::class, function () {
            return new UserRoleRepository(new UserRole());
        });

        $this->app->bind(DatingCardRepositoryContract::class, function () {
            return new DatingCardRepository(new DatingCard());
        });

        $this->app->bind(TagRepositoryContract::class, function () {
            return new TagRepository(new Tag());
        });

        $this->app->bind(LikeRepositoryContract::class, function() {
            return new LikeRepository(new Like());
        });

        $this->app->bind(FilterRepositoryContract::class, FilterRepository::class);
        
        $this->app->bind(AuthServiceContract::class, AuthService::class);

        $this->app->bind(TagSynchronizerContract::class, TagSynchronizer::class);

        $this->app->bind(UserServiceContract::class, UserService::class);

        $this->app->bind(DatingCardServiceContract::class, DatingCardService::class);

        $this->app->bind(ImageServiceContract::class, ImageService::class);

        $this->app->bind(PrivateFilesServiceContract::class, PrivateFilesService::class);

        $this->app->bind(LikeServiceContract::class, LikeService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('view-image', function ($user, $image) {
            //Ну если это карточки - то любой может смотреть
            if ($image->imageable_type == DatingCard::class) {
                return true;
            }
            return false;
        });
    }
}
