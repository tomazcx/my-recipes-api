<?php

namespace Src\Implementation\Auth\Dto;

use Src\Domain\Auth\Dto\AbstractAuthenticateDto;

class AuthenticateDto extends AbstractAuthenticateDto{

	public function __construct($data)
	{
		$this->email = $data['email'];
		$this->password = $data['password'];	
	}

}
