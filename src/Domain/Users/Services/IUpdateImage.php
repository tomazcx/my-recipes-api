<?php

namespace Src\Domain\Users\Services;

use Src\Domain\Users\Entities\User;

interface IUpdateImage{

	public function execute(string $image, int $id):User;
	
}
