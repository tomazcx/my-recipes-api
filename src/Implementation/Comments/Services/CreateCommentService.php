<?php

namespace Src\Implementation\Comments\Services;

use Src\Domain\Comments\Dto\AbstractCreateCommentDto;
use Src\Domain\Comments\Entities\AbstractComment;
use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Domain\Comments\Services\AbstractCreateComment;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Implementation\Common\Error\NotFoundError;

class CreateCommentService extends AbstractCreateComment{

	protected AbstractCommentRepository $commentRepository;
	protected AbstractRecipeRepository $recipeRepository;
	protected AbstractUserRepository $userRepository;

	public function __construct(AbstractCommentRepository $commentRepository, AbstractRecipeRepository $recipeRepository, AbstractUserRepository $userRepository)
	{
		$this->commentRepository = $commentRepository;	
		$this->recipeRepository = $recipeRepository;
		$this->userRepository = $userRepository;
	}

	public function execute(AbstractCreateCommentDto $createCommentDto, int $userId, int $recipeId): AbstractComment
	{
		$userExists = $this->userRepository->exists($userId);

		if(!$userExists){
			throw new NotFoundError('Usuário não encontrado');
		}

		$recipeExists = $this->recipeRepository->exists($recipeId);

		if(!$recipeExists){
			throw new NotFoundError('Receita não encontrada');
		}

		$comment = $this->commentRepository->create($createCommentDto, $userId, $recipeId);

		return $comment;
	}

}
