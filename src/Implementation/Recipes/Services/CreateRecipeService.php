<?php

namespace Src\Implementation\Recipes\Services;

use Src\Domain\Recipes\Dto\AbstractCreateRecipeDto;
use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractCreateRecipe;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Implementation\Common\Error\NotFoundError;

class CreateRecipeService extends AbstractCreateRecipe{

	protected AbstractUserRepository $userRepository;
	protected AbstractRecipeRepository $recipeRepository;

	public function __construct(AbstractUserRepository $userRepository, AbstractRecipeRepository $recipeRepository)
	{
		$this->userRepository = $userRepository;
		$this->recipeRepository = $recipeRepository;	
	}

	public function execute(AbstractCreateRecipeDto $createRecipeDto, int $userId): AbstractRecipe
	{
		$userExists = $this->userRepository->exists($userId);

		if(!$userExists){
			throw new NotFoundError('Usuário não encontrado');
		}

		$recipe = $this->recipeRepository->create($createRecipeDto, $userId);

		return $recipe;
	}

}
