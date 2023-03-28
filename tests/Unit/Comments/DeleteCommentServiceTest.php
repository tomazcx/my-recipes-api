<?php

namespace Tests\Unit\Comments;

use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Domain\Comments\Services\AbstractDeleteComment;
use Src\Implementation\Comments\Services\DeleteCommentService;
use Src\Implementation\Common\Error\ForbiddenError;
use Src\Implementation\Common\Error\NotFoundError;
use Tests\TestCase;
use Tests\Unit\TestUser;

class DeleteCommentServiceTest extends TestCase{

	protected AbstractDeleteComment $service;

	public function test_it_should_delete_the_comment_with_the_informed_id():void	
	{
		$user = new TestUser();
		$user->id = 1;

		$comment = new TestComment();
		$comment->id = 1;
		$comment->content = 'test';
		$comment->author = $user;

		$commentRepository = $this->getMockForAbstractClass(AbstractCommentRepository::class);
		$commentRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$commentRepository->expects($this->once())->method('show')->will($this->returnValue($comment));
		$commentRepository->expects($this->once())->method('delete');

		$this->service = new DeleteCommentService($commentRepository);

		$this->service->execute($comment->id, $user->id);
	}

	public function test_it_should_fail_due_to_not_found_comment():void
	{
		$this->expectException(NotFoundError::class);

		$commentRepository = $this->getMockForAbstractClass(AbstractCommentRepository::class);
		$commentRepository->expects($this->once())->method('exists')->will($this->returnValue(false));

		$this->service = new DeleteCommentService($commentRepository);

		$commentId = 1;
		$userId = 1;

		$this->service->execute($commentId, $userId);
	}

	public function test_it_should_fail_due_to_lack_of_permission_to_delete():void
	{
		$this->expectException(ForbiddenError::class);

		$user = new TestUser();
		$user->id = 1;

		$comment = new TestComment();
		$comment->id = 1;
		$comment->content = 'test';
		$comment->author = $user;

		$commentRepository = $this->getMockForAbstractClass(AbstractCommentRepository::class);
		$commentRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$commentRepository->expects($this->once())->method('show')->will($this->returnValue($comment));

		$this->service = new DeleteCommentService($commentRepository);

		$userId = 2;

		$this->service->execute($comment->id, $userId);
	}

}
