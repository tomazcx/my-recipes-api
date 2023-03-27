<?php

namespace Src\Domain\Recipes\Services;

use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;

abstract class AbstractShowRecipes {

	protected AbstractRecipeRepository $recipeRepository;

	abstract function execute(?string $name, ?int $categoryId):array;

}
