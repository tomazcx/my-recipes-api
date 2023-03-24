<?php

namespace Src\Implementation\Auth\Entities;

use Src\Domain\Auth\Entities\AbstractAuthToken;

class AuthToken extends AbstractAuthToken{

	public function __construct($data)
	{
		$this->token = $data['token'];
		$this->token_type = $data['token_type'];
	}

}
