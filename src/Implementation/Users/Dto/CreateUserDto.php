<?php

namespace Src\Implementation\Users\Dto;

use Src\Domain\Users\Dto\AbstractCreateUserDto;

class CreateUserDto extends AbstractCreateUserDto {

	public function __construct(array $data)
	{
		$this->name = $data['name'];
		$this->email = $data['email'];
		$this->description = $data['description'];
		$this->city = $data['city'];
		$this->state = $data['state'];
		$this->country = $data['country'];
	}

}
