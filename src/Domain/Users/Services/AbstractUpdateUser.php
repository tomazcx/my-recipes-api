<?php

namespace Src\Domain\Users\Services;

use Src\Domain\Users\Dto\AbstractUpdateUserDto;
use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;

abstract class AbstractUpdateUser{

	protected AbstractUserRepository $userRepository;

	abstract function execute(AbstractUpdateUserDto $updateUserDto, int $id):AbstractUser;
	
}
