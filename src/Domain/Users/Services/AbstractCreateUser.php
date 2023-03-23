<?php

namespace Src\Domain\Users\Services;

use Src\Domain\Users\Dto\AbstractCreateUserDto;
use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;

abstract class AbstractCreateUser{

	protected AbstractUserRepository $userRepository;

	abstract function execute(AbstractCreateUserDto $createUserDto): AbstractUser;
	
}
