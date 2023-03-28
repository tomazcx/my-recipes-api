<?php

namespace Src\Implementation\Comments\Services;

use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Domain\Comments\Services\AbstractDeleteComment;
use Src\Implementation\Common\Error\ForbiddenError;
use Src\Implementation\Common\Error\NotFoundError;

class DeleteCommentService extends AbstractDeleteComment{

	protected AbstractCommentRepository $commentRepository;

	public function __construct(AbstractCommentRepository $commentRepository)
	{
		$this->commentRepository = $commentRepository;
	}

	public function execute(int $commentId, int $userId): void
	{
		$commentExists = $this->commentRepository->exists($commentId);

		if(!$commentExists){
			throw new NotFoundError('Comentário não encontrado');
		}

		$coment = $this->commentRepository->show($commentId);

		if($coment->author->id != $userId){
			throw new ForbiddenError("Você não possui permissão para realizar essa ação");
		}

		$this->commentRepository->delete($commentId);

	}

}
