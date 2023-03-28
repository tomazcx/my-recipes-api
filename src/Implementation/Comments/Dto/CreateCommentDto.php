<?php

namespace Src\Implementation\Comments\Dto;

use Src\Domain\Comments\Dto\AbstractCreateCommentDto;

class CreateCommentDto extends AbstractCreateCommentDto{

	public function __construct($data)
	{
		$this->content = $data['content'];
	}

}
