<?php

namespace Src\Implementation\Comments\Services;

use Src\Domain\Comments\Entities\AbstractComment;
use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Domain\Comments\Services\AbstractShowComment;
use Src\Implementation\Common\Error\NotFoundError;

class ShowCommentService extends AbstractShowComment{

	protected AbstractCommentRepository $commentRepository;

	public function __construct(AbstractCommentRepository $commentRepository)
	{
		$this->commentRepository = $commentRepository;	
	}

	public function execute(int $id): AbstractComment
	{
		$commentExists = $this->commentRepository->exists($id);

		if(!$commentExists){
			throw new NotFoundError('Comentário não encontrado.');
		}

		$comment = $this->commentRepository->show($id);

		return $comment;
	}

}
