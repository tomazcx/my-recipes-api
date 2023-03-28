<?php

namespace Src\Domain\Comments\Services;

use Src\Domain\Comments\Entities\AbstractComment;
use Src\Domain\Comments\Repositories\AbstractCommentRepository;

abstract class AbstractShowComment{

	protected AbstractCommentRepository $commentRepository;

	abstract function execute(int $id):AbstractComment;

}
