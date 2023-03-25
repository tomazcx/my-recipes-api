<?php

namespace Src\Domain\Users\Services;

use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;

abstract class AbstractUpdateImage{

	protected AbstractUserRepository $userRepository;

	abstract function execute(string $image, int $id):AbstractUser;
	
}
