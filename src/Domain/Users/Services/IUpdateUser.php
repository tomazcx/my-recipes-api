<?php

namespace Src\Domain\Users\Services;

use Src\Domain\Users\Entities\User;
use Src\Domain\Users\Dto\UpdateUserDto;

interface IUpdateUSer{

	public function execute(UpdateUserDto $updateUserDto):User;
	
}
