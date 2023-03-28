<?php

namespace Src\Domain\Comments\Services;

use Src\Domain\Comments\Dto\AbstractCreateCommentDto;
use Src\Domain\Comments\Entities\AbstractComment;
use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Users\Repositories\AbstractUserRepository;

abstract class AbstractCreateComment{

	protected AbstractRecipeRepository $recipeRepository;
	protected AbstractUserRepository $userRepository;
	protected AbstractCommentRepository $commentRepository;

	abstract function execute(AbstractCreateCommentDto $createCommentDto, int $userId, int $recipeId):AbstractComment;

}
