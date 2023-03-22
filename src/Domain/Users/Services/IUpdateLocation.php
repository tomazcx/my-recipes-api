<?php

namespace Src\Domain\Users\Services;

use Src\Domain\Users\Entities\User;
use Src\Domain\Users\Dto\UpdateLocationDto;

interface IUpdateLocation{

	public function execute(UpdateLocationDto $updateLocationDto):User;
	
}
