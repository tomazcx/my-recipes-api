<?php

namespace Src\Implementation\Recipes\Services;

use Illuminate\Support\Facades\Storage;
use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractUpdateRecipeImage;
use Src\Implementation\Common\Error\ForbiddenError;
use Src\Implementation\Common\Error\NotFoundError;

class UpdateRecipeImageService extends AbstractUpdateRecipeImage{

	protected AbstractRecipeRepository $recipeRepository;

	public function __construct(AbstractRecipeRepository $recipeRepository)
	{
		$this->recipeRepository = $recipeRepository;	
	}

	public function execute(string $image, int $recipeId, int $userId): AbstractRecipe
	{
		$recipeExists = $this->recipeRepository->exists($recipeId);

		if(!$recipeExists){
			Throw new NotFoundError('Receita não encontrada');
		}

		$recipe = $this->recipeRepository->show($recipeId);

		if($recipe->author->id != $userId){
			Throw new ForbiddenError('Você não possui permissão para realizar essa ação');
		}

		Storage::delete($recipe->image);

		$newRecipe = $this->recipeRepository->updateImage($image, $recipeId);

		return $newRecipe;
	}

}
