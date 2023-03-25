<?php

namespace Src\Domain\Users\Repositories;

use Src\Domain\Users\Dto\AbstractCreateUserDto;
use Src\Domain\Users\Dto\AbstractUpdateLocationDto;
use Src\Domain\Users\Dto\AbstractUpdateUserDto;
use Src\Domain\Users\Entities\AbstractUser;

abstract class AbstractUserRepository{

	public abstract function exists(int $id):bool;
	public abstract function show(int $id):AbstractUser;
	public abstract function emailExists(string $email):bool;
	public abstract function create(AbstractCreateUserDto $createUserDto):AbstractUser;
	public abstract function update(AbstractUpdateUserDto $updateUserDto, int $id):AbstractUser;
	public abstract function updateLocation(AbstractUpdateLocationDto $updateLocationDto, int $id):AbstractUser;
	public abstract function updateImage(string $image, int $id):AbstractUser;
	public abstract function delete(int $id):void;
}
