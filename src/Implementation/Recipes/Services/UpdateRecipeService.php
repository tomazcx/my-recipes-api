<?php

namespace Src\Implementation\Recipes\Services;

use Src\Domain\Recipes\Dto\AbstractUpdateRecipeDto;
use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractUpdateRecipe;
use Src\Implementation\Common\Error\ForbiddenError;
use Src\Implementation\Common\Error\NotFoundError;

class UpdateRecipeService extends AbstractUpdateRecipe{

	protected AbstractRecipeRepository $recipeRepository;

	public function __construct(AbstractRecipeRepository $recipeRepository)
	{
		$this->recipeRepository = $recipeRepository;	
	}

	public function execute(AbstractUpdateRecipeDto $updateRecipeDto, int $recipeId, int $userId): AbstractRecipe
	{
		$recipeExists = $this->recipeRepository->exists($recipeId);

		if(!$recipeExists){
			throw new NotFoundError('Receita não encontrada');
		}

		$recipe = $this->recipeRepository->show($recipeId);

		if($recipe->author->id != $userId){
			throw new ForbiddenError('Você não possui permissão para realizar essa ação.');
		}

		$updatedRecipe = $this->recipeRepository->update($updateRecipeDto, $recipeId);

		return $updatedRecipe;
	}

}
