<?php

namespace Src\Domain\Comments\Repositories;

use Src\Domain\Comments\Dto\AbstractCreateCommentDto;
use Src\Domain\Comments\Entities\AbstractComment;

abstract class AbstractCommentRepository{

	abstract function exists(int $id):bool;
	abstract function show(int $id):AbstractComment;
	abstract function create(AbstractCreateCommentDto $createCommentDto, int $userId, int $recipeId):AbstractComment;
	abstract function showRecipeComments(int $recipeId):array;
	abstract function delete(int $id):void;
}
