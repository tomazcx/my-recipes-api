<?php 

namespace Src\Implementation\Recipes\Services;

use Illuminate\Support\Facades\Storage;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractDeleteRecipe;
use Src\Implementation\Common\Error\ForbiddenError;
use Src\Implementation\Common\Error\NotFoundError;

class DeleteRecipeService extends AbstractDeleteRecipe{

	protected AbstractRecipeRepository $recipeRepository;

	public function __construct(AbstractRecipeRepository $recipeRepository)
	{
		$this->recipeRepository = $recipeRepository;	
	}	

	public function execute(int $recipeId, int $userId): void
	{
		$recipeExists = $this->recipeRepository->exists($recipeId);

		if(!$recipeExists){
			Throw new NotFoundError('Receita não encontrada');
		}

		$recipe = $this->recipeRepository->show($recipeId);

		if($recipe->author->id != $userId){
			Throw new ForbiddenError('Você não possui permissão para realizar essa ação.');
		}

		Storage::delete($recipe->image);

		$this->recipeRepository->delete($recipeId);
	}

}
