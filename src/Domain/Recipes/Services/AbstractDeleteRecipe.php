<?php

namespace Src\Domain\Recipes\Services;

use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Users\Repositories\AbstractUserRepository;

abstract class AbstractDeleteRecipe{

	protected AbstractRecipeRepository $recipeRepository;
	protected AbstractUserRepository $userRepository;

	abstract function execute(int $recipeId, int $userId):void;

}
