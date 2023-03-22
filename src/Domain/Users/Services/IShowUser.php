<?php

namespace Src\Domain\Users\Services;

use Src\Domain\Users\Entities\User;

interface IShowUser{

	public function execute(int $id):User;
	
}
