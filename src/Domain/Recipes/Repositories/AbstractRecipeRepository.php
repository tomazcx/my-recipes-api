<?php

namespace Src\Domain\Recipes\Repositories;

use Src\Domain\Recipes\Dto\AbstractCreateRecipeDto;
use Src\Domain\Recipes\Dto\AbstractUpdateRecipeDto;
use Src\Domain\Recipes\Entities\AbstractRecipe;

abstract class AbstractRecipeRepository{

	abstract function exists(int $id):bool;
	abstract function show(int $id):AbstractRecipe;
	abstract function showRecipesByCategory(int $cateogoryId):array;
	abstract function showRecipesByName(string $name):array;
	abstract function create(AbstractCreateRecipeDto $createRecipeDto):AbstractRecipe;
	abstract function update(AbstractUpdateRecipeDto $updateRecipeDto, int $id):AbstractRecipe;
	abstract function updateImage(string $image, int $id):AbstractRecipe;
	abstract function delete(int $id):void;

}
