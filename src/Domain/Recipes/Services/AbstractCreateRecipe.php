<?php

namespace Src\Domain\Recipes\Services;

use Src\Domain\Recipes\Dto\AbstractCreateRecipeDto;
use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Users\Repositories\AbstractUserRepository;

abstract class AbstractCreateRecipe{

	protected AbstractRecipeRepository $recipeRepository;
	protected AbstractUserRepository $userRepository;

	abstract function execute(AbstractCreateRecipeDto $createRecipeDto, int $userId):AbstractRecipe;

}
