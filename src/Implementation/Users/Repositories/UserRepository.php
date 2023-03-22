<?php


namespace Src\Implementation\Users\Repositories;

use App\Models\Users as UserModel;
use Src\Domain\User\Dto\AbstractCreateUserDto;
use Src\Domain\Users\Dto\UpdateLocationDto;
use Src\Domain\Users\Dto\UpdateUserDto;
use Src\Domain\Users\Entities\User;
use Src\Domain\Users\Repositories\IUserRepository;

class UserRepository implements IUserRepository{

	protected UserModel $userModel;

	public function __construct(UserModel $userModel)
	{
		$this->userModel = $userModel;	
	}

	public function exists(int $id): bool
	{
		$user = $this->userModel::find($id);
		return !!$user;
	}

	public function show(int $id): User
	{
		$user = $this->userModel::find($id);
		return $user;
	}

	public function emailExists(string $email): bool
	{
		$user = $this->userModel::where('email', $email)->first();
		return !!$user;
	}

	public function create(AbstractCreateUserDto $createUserDto): User
	{
		$user = $this->userModel::create($createUserDto);
		$user->location()->create($createUserDto);
		return $user;
	}

	public function update(UpdateUserDto $updateUserDto, int $id): User
	{
		$user = $this->userModel::find($id);
		$user->update($updateUserDto);
		return $user;
	}

	public function updateImage(string $image, int $id): User
	{
		$user = $this->userModel::find($id);
		$user->update([
			"image"=> $image
		]);
		return $user;
	}

	public function updateLocation(UpdateLocationDto $updateLocationDto, int $id): User
	{	
		$user = $this->userModel::find($id);
		$user->location()::update($updateLocationDto);
		return $user;
	}

	public function delete(int $id): void
	{
		$this->userModel::destroy($id);
	}
	

}
