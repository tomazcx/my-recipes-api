<?php

namespace Src\Domain\Recipes\Services;

use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;

abstract class AbstractShowRecipe{

	protected AbstractRecipeRepository $recipeRepository;

	abstract function execute(int $id):AbstractRecipe;

}
