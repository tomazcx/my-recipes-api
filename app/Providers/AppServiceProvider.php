<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Auth\Services\AbstractAuthenticate;
use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Domain\Comments\Services\AbstractCreateComment;
use Src\Domain\Comments\Services\AbstractDeleteComment;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractCreateRecipe;
use Src\Domain\Recipes\Services\AbstractDeleteRecipe;
use Src\Domain\Recipes\Services\AbstractShowRecipe;
use Src\Domain\Recipes\Services\AbstractShowRecipes;
use Src\Domain\Recipes\Services\AbstractUpdateRecipe;
use Src\Domain\Recipes\Services\AbstractUpdateRecipeImage;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractCreateUser;
use Src\Domain\Users\Services\AbstractDeleteUser;
use Src\Domain\Users\Services\AbstractShowUser;
use Src\Domain\Users\Services\AbstractUpdateImage;
use Src\Domain\Users\Services\AbstractUpdateLocation;
use Src\Domain\Users\Services\AbstractUpdateUser;
use Src\Implementation\Auth\Services\AuthenticateService;
use Src\Implementation\Comments\Repositories\CommentRepository;
use Src\Implementation\Comments\Services\CreateCommentService;
use Src\Implementation\Comments\Services\DeleteCommentService;
use Src\Implementation\Recipes\Repositories\RecipeRepository;
use Src\Implementation\Recipes\Services\CreateRecipeService;
use Src\Implementation\Recipes\Services\ShowRecipeService;
use Src\Implementation\Recipes\Services\DeleteRecipeService;
use Src\Implementation\Recipes\Services\ShowRecipesService;
use Src\Implementation\Recipes\Services\UpdateRecipeImageService;
use Src\Implementation\Recipes\Services\UpdateRecipeService;
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

	    //USER BINDS
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

	    //RECIPE BINDS
	    $this->app->bind(
		    AbstractRecipeRepository::class,
		    RecipeRepository::class
	    );

	    $this->app->bind(
		    AbstractCreateRecipe::class,
		    CreateRecipeService::class
	    );

	    $this->app->bind(
		    AbstractShowRecipe::class,
		    ShowRecipeService::class
	    );

	    $this->app->bind(
		    AbstractDeleteRecipe::class,
		    DeleteRecipeService::class
	    );

	    $this->app->bind(
		    AbstractUpdateRecipeImage::class,
		    UpdateRecipeImageService::class
	    );

	    $this->app->bind(
		    AbstractShowRecipes::class,
		    ShowRecipesService::class
	    );

	    $this->app->bind(
		    AbstractUpdateRecipe::class,
		    UpdateRecipeService::class
	    );

	    //COMMENT BINDS
	    $this->app->bind(
		    AbstractCommentRepository::class,
		    CommentRepository::class
	    );

	    $this->app->bind(
		    AbstractCreateComment::class,
		    CreateCommentService::class
	    );

	    $this->app->bind(
		    AbstractDeleteComment::class,
		    DeleteCommentService::class
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
