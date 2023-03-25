<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Auth\Services\AbstractAuthenticate;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractCreateUser;
use Src\Domain\Users\Services\AbstractDeleteUser;
use Src\Domain\Users\Services\AbstractShowUser;
use Src\Domain\Users\Services\AbstractUpdateImage;
use Src\Domain\Users\Services\AbstractUpdateLocation;
use Src\Domain\Users\Services\AbstractUpdateUser;
use Src\Implementation\Auth\Services\AuthenticateService;
use Src\Implementation\Users\Repositories\UserRepository;
use Src\Implementation\Users\Services\CreateUserService;
use Src\Implementation\Users\Services\DeleteUserService;
use Src\Implementation\Users\Services\ShowUserService;
use Src\Implementation\Users\Services\UpdateImageService;
use Src\Implementation\Users\Services\UpdateLocationService;
use Src\Implementation\Users\Services\UpdateUserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

	    $this->app->bind(
		    AbstractUpdateImage::class,
		    UpdateImageService::class
	    );

	    $this->app->bind(
		    AbstractUpdateLocation::class,
		    UpdateLocationService::class
	    );

	    $this->app->bind(
		    AbstractUpdateUser::class,
		    UpdateUserService::class
	    );

	    $this->app->bind(
		    AbstractDeleteUser::class,
		    DeleteUserService::class
	    );

	    $this->app->bind(
		    AbstractAuthenticate::class,
		    AuthenticateService::class
	    );

	    $this->app->bind(
		    AbstractCreateUser::class,
		    CreateUserService::class
	    );

	    $this->app->bind(
		    AbstractShowUser::class,
		    ShowUserService::class
	    );

	    $this->app->bind(
		    AbstractUserRepository::class,
		    UserRepository::class
	    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
