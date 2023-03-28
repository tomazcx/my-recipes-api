<?php

namespace Tests\Unit\Comments;

use Src\Domain\Comments\Entities\AbstractComment;
use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Domain\Comments\Services\AbstractCreateComment;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Implementation\Comments\Services\CreateCommentService;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Comments\Dto\CreateCommentDto;
use Tests\TestCase;

class TestComment extends AbstractComment{}

class CreateCommentServiceTest extends TestCase{

	protected AbstractCreateComment $service;

	public function test_it_should_create_a_comment():void
	{
		$expectedOutput = new TestComment();
		$expectedOutput->content = 'test';

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);
		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(true));

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(true));

		$commentRepository = $this->getMockForAbstractClass(AbstractCommentRepository::class);
		$commentRepository->expects($this->once())->method('create')->will($this->returnValue($expectedOutput));

		$this->service = new CreateCommentService($commentRepository, $recipeRepository, $userRepository);

		$createCommentDto = new CreateCommentDto([
			'content' => 'test'
		]);

		$userId = 1;
		$recipeId = 1;

		$result = $this->service->execute($createCommentDto, $userId, $recipeId);

		$this->assertEquals($result, $expectedOutput);
	}

	public function test_it_should_fail_due_to_not_found_user():void
	{
		$this->expectException(NotFoundError::class);

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);
		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(false));

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);

		$commentRepository = $this->getMockForAbstractClass(AbstractCommentRepository::class);

		$this->service = new CreateCommentService($commentRepository, $recipeRepository, $userRepository);

		$createCommentDto = new CreateCommentDto([
			'content' => 'test'
		]);

		$userId = 2;
		$recipeId = 1;

		$this->service->execute($createCommentDto, $userId, $recipeId);
	}

	public function test_it_should_fail_due_to_not_found_recipe():void
	{
		$this->expectException(NotFoundError::class);

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);
		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(true));

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(false));

		$commentRepository = $this->getMockForAbstractClass(AbstractCommentRepository::class);

		$this->service = new CreateCommentService($commentRepository, $recipeRepository, $userRepository);

		$createCommentDto = new CreateCommentDto([
			'content' => 'test'
		]);

		$userId = 1;
		$recipeId = 2;

		$this->service->execute($createCommentDto, $userId, $recipeId);
	}

}
