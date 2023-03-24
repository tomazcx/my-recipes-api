<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Auth\Services\AbstractAuthenticate;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractCreateUser;
use Src\Domain\Users\Services\AbstractShowUser;
use Src\Implementation\Auth\Services\AuthenticateService;
use Src\Implementation\Users\Repositories\UserRepository;
use Src\Implementation\Users\Services\CreateUserService;
use Src\Implementation\Users\Services\ShowUserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
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
