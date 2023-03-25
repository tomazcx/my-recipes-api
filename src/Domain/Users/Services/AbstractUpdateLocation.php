<?php

namespace Src\Domain\Users\Services;

use Src\Domain\Users\Dto\AbstractUpdateLocationDto;
use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;

abstract class AbstractUpdateLocation{

	protected AbstractUserRepository $userRepository;

	abstract function execute(AbstractUpdateLocationDto $updateLocationDto, int $id):AbstractUser;
	
}
