<?php

namespace Src\Domain\Users\Services;

use Src\Domain\Users\Repositories\AbstractUserRepository;

abstract class AbstractDeleteUser{

	protected AbstractUserRepository $userRepository;

	abstract function execute(int $id):void;
	
}
