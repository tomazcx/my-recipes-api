<?php

namespace Src\Domain\Users\Repositories;

use Src\Domain\Users\Dto\AbstractCreateUserDto;
use Src\Domain\Users\Dto\UpdateLocationDto;
use Src\Domain\Users\Dto\UpdateUserDto;
use Src\Domain\Users\Entities\User;

abstract class IUserRepository{

	public abstract function exists(int $id):bool;
	public abstract function show(int $id):User;
	public abstract function emailExists(string $email):bool;
	public abstract function create(AbstractCreateUserDto $createUserDto):User;
	public abstract function update(UpdateUserDto $updateUserDto, int $id):User;
	public abstract function updateLocation(UpdateLocationDto $updateLocationDto, int $id):User;
	public abstract function updateImage(string $image, int $id):User;
	public abstract function delete(int $id):void;
}
