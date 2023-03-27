<?php

namespace Src\Domain\Recipes\Services;

use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;

abstract class AbstractUpdateRecipeImage{

	protected AbstractRecipeRepository $recipeRepository;

	abstract function execute(string $image, int $recipeId, int $userId):AbstractRecipe;

}
