<?php

namespace Src\Domain\Recipes\Services;

use Src\Domain\Recipes\Dto\AbstractUpdateRecipeDto;
use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;

abstract class AbstractUpdateRecipe{

	protected AbstractRecipeRepository $recipeRepository;

	abstract function execute(AbstractUpdateRecipeDto $updateRecipeDto, int $recipeId, int $userId):AbstractRecipe;

}
