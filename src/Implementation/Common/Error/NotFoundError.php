<?php

namespace Src\Implementation\Common\Error;

use Error;

class NotFoundError extends Error{

	public $message;

	public function __construct(string $message)
	{
		parent::__construct();
		$this->message = $message;
	}


}
