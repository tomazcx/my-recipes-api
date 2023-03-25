<?php

namespace Src\Domain\Recipes\Services;

use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;

abstract class AbstractShowRecipesByName{

	protected AbstractRecipeRepository $recipeRepository;

	abstract function execute(string $name):array;

}
