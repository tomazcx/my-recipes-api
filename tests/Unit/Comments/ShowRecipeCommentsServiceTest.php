<?php

namespace Tests\Unit\Comments;

use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Domain\Comments\Services\AbstractShowRecipeComments;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Implementation\Comments\Services\ShowRecipeCommentsService;
use Src\Implementation\Common\Error\NotFoundError;
use Tests\TestCase;

class ShowRecipeCommentsServiceTest extends TestCase{

	protected AbstractShowRecipeComments $service;

	public function test_it_should_show_all_comments_from_recipe():void
	{
		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(true));

		$commentRepository = $this->getMockForAbstractClass(AbstractCommentRepository::class);
		$commentRepository->expects($this->once())->method('showRecipeComments')->will($this->returnValue([]));

		$this->service = new ShowRecipeCommentsService($commentRepository, $recipeRepository);

		$recipeId = 1;

		$result = $this->service->execute($recipeId);
	}

	public function test_it_should_fail_due_to_not_found_recipe():void
	{
		$this->expectException(NotFoundError::class);

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(false));

		$commentRepository = $this->getMockForAbstractClass(AbstractCommentRepository::class);
		$commentRepository->expects($this->never())->method('showRecipeComments')->will($this->returnValue([]));

		$this->service = new ShowRecipeCommentsService($commentRepository, $recipeRepository);

		$recipeId = 1;

		$result = $this->service->execute($recipeId);

	}

}
