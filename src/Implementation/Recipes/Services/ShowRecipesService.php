<?php

namespace Src\Implementation\Recipes\Services;

use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractShowRecipes;

class ShowRecipesService extends AbstractShowRecipes{

	protected AbstractRecipeRepository $recipeRepository;

	public function __construct(AbstractRecipeRepository $recipeRepository)
	{
		$this->recipeRepository = $recipeRepository;	
	}	

	public function execute(?string $name, ?int $categoryId): array
	{
		if(!$name && !$categoryId){
			return $this->recipeRepository->all();
		}

		if(!$name && $categoryId){
			return $this->recipeRepository->showRecipesByCategory($categoryId);
		}

		if($name && !$categoryId){
			return $this->recipeRepository->showRecipesByName($name);
		}

		return $this->recipeRepository->showRecipesByCategoryAndName($name, $categoryId);
	}
}
