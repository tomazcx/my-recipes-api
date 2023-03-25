<?php

namespace Src\Domain\Recipes\Services;

use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Users\Repositories\AbstractUserRepository;

abstract class AbstractUpdateRecipeImage{

	protected AbstractRecipeRepository $recipeRepository;
	protected AbstractUserRepository $userRepository;

	abstract function execute(string $image, int $recipeId, int $userId):AbstractRecipe;

}
