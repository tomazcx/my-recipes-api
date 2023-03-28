<?php

namespace Src\Domain\Comments\Services;

use Src\Domain\Comments\Repositories\AbstractCommentRepository;

abstract class AbstractDeleteComment{

	protected AbstractCommentRepository $commentRepository;

	abstract function execute(int $commentId, int $userId):void;

}
