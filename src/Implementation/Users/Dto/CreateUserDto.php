<?php

namespace Src\Implementation\Users\Dto;

use Src\Domain\Users\Dto\AbstractCreateUserDto;

class CreateUserDto extends AbstractCreateUserDto {

	public function __construct(array $data)
	{
		$this->name = $data['name'];
		$this->email = $data['email'];
		$this->password = $data['password'];
		$this->confirmPassword = $data['confirmPassword'];
		$this->description = $data['description']?? null;
		$this->city = $data['city']?? null;
		$this->state = $data['state']?? null;
		$this->country = $data['country'];
	}

}
