<?php

namespace Src\Domain\Recipes\Services;

use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;

abstract class AbstractShowRecipesByCategory{

	protected AbstractRecipeRepository $recipeRepository;

	abstract function execute(int $categoryId):array;

}
