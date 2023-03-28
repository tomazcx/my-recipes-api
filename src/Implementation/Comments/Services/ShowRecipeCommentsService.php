<?php

namespace Src\Implementation\Comments\Services;

use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Domain\Comments\Services\AbstractShowRecipeComments;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Implementation\Common\Error\NotFoundError;

class ShowRecipeCommentsService extends AbstractShowRecipeComments{

	protected AbstractCommentRepository $commentRepository;
	protected AbstractRecipeRepository $recipeRepository;

	public function __construct(AbstractCommentRepository $commentRepository, AbstractRecipeRepository $recipeRepository)
	{
		$this->commentRepository = $commentRepository;
		$this->recipeRepository = $recipeRepository;
	}

	public function execute($recipeId): array
	{
		$recipeExists = $this->recipeRepository->exists($recipeId);

		if(!$recipeExists){
			throw new NotFoundError('Receita não encontrada');
		}

		$comments = $this->commentRepository->showRecipeComments($recipeId);

		return $comments;
	}
}
