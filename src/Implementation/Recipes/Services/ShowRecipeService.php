<?php

namespace Src\Implementation\Recipes\Services;

use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractShowRecipe;
use Src\Implementation\Common\Error\NotFoundError;

class ShowRecipeService extends AbstractShowRecipe{

	protected AbstractRecipeRepository $recipeRepository;

	public function __construct(AbstractRecipeRepository $recipeRepository)
	{
		$this->recipeRepository = $recipeRepository;	
	}

	public function execute(int $id): AbstractRecipe
	{
		$recipeExists = $this->recipeRepository->exists($id);

		if(!$recipeExists){
			throw new NotFoundError('Receita não encontrada');
		}

		$recipe = $this->recipeRepository->show($id);

		return $recipe;
	}

}
