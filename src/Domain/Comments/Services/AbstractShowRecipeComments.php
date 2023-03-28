<?php

namespace Src\Domain\Comments\Services;

use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;

abstract class AbstractShowRecipeComments{

	protected AbstractRecipeRepository $recipeRepository;
	protected AbstractCommentRepository $commentRepository;

	abstract function execute($recipeId):array;

}
