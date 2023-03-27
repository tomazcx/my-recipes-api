<?php

namespace Src\Domain\Recipes\Services;

use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;

abstract class AbstractDeleteRecipe{

	protected AbstractRecipeRepository $recipeRepository;

	abstract function execute(int $recipeId, int $userId):void;

}
