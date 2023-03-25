<?php

namespace Src\Implementation\Users\Dto;

use Src\Domain\Users\Dto\AbstractUpdateUserDto;

class UpdateUserDto extends AbstractUpdateUserDto{

	public function __construct($data)
	{
		$this->name = $data['name']?? null;
		$this->email = $data['email']?? null;
		$this->description = $data['description']?? null;
	}

}
