<?php

namespace Tests\Unit\Comments;

use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Domain\Comments\Services\AbstractShowComment;
use Src\Implementation\Comments\Services\ShowCommentService;
use Src\Implementation\Common\Error\NotFoundError;
use Tests\TestCase;

class ShowCommentServiceTest extends TestCase{

	protected AbstractShowComment $service;

	public function test_it_should_show_the_comment_with_the_informed_id():void
	{
		$expectedOutput = new TestComment();
		$expectedOutput->id = 1;
		$expectedOutput->content = 'test';

		$commentRepository = $this->getMockForAbstractClass(AbstractCommentRepository::class);
		$commentRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$commentRepository->expects($this->once())->method('show')->will($this->returnValue($expectedOutput));

		$this->service = new ShowCommentService($commentRepository);

		$result = $this->service->execute($expectedOutput->id);

		$this->assertEquals($result, $expectedOutput);
	}

	
	public function test_it_should_fail_due_to_not_found_comment():void
	{
		$this->expectException(NotFoundError::class);

		$commentRepository = $this->getMockForAbstractClass(AbstractCommentRepository::class);
		$commentRepository->expects($this->once())->method('exists')->will($this->returnValue(false));

		$this->service = new ShowCommentService($commentRepository);

		$commentId = 1;
		$userId = 1;

		$this->service->execute($commentId, $userId);
	}


}
