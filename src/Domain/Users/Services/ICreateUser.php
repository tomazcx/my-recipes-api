<?php

namespace Src\Domain\Users\Services;

use Src\Domain\Users\Dto\AbstractCreateUserDto;
use Src\Domain\Users\Entities\User;

interface ICreateUser{

	public function execute(AbstractCreateUserDto $createUserDto):User;
	
}
