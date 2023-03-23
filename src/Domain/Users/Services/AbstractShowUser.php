<?php

namespace Src\Domain\Users\Services;

use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;

abstract class AbstractShowUser{

	protected AbstractUserRepository $userRepository;

	abstract function execute(int $id):AbstractUser;
	
}
