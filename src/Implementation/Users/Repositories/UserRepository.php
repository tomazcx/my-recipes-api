<?php


namespace Src\Implementation\Users\Repositories;

use App\Models\Location as LocationModel;
use App\Models\User as UserModel;
use Src\Domain\Users\Dto\AbstractCreateUserDto;
use Src\Domain\Users\Dto\UpdateLocationDto;
use Src\Domain\Users\Dto\UpdateUserDto;
use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Implementation\Users\Entities\User;

class UserRepository extends AbstractUserRepository{

	protected UserModel $userModel;
	protected LocationModel $locationModel;

	public function __construct(UserModel $userModel, LocationModel $locationModel)
	{
		$this->userModel = $userModel;	
		$this->locationModel = $locationModel;
	}

	public function exists(int $id): bool
	{
		$user = $this->userModel::find($id);
		return !!$user;
	}

	public function show(int $id): AbstractUser
	{
		$user = $this->userModel::with('location')->find($id);

		$userObj = new User($user);
	
		return $userObj;
	}

	public function emailExists(string $email): bool
	{
		$user = $this->userModel::where('email', $email)->first();
		return !!$user;
	}

	public function create(AbstractCreateUserDto $createUserDto):AbstractUser
	{
		$user = $this->userModel::create([
			'name' => $createUserDto->name,
			'email' => $createUserDto->email,
			'password' => $createUserDto->password,
			'description' => $createUserDto->description
		]);	

		$location = $this->locationModel::create([
			'city' => $createUserDto->city,
			'state' => $createUserDto->state,
			'country' => $createUserDto->country,
			'user_id' => $user['id']		
		]);

		$user->location()->associate($location);
		$user->save();

		$user['location'] = [
			'city' => $location->city,
			'state' => $location->state,
			'country' => $location->country
		];

		$userObj = new User($user);

		return $userObj;
	}

	public function update(UpdateUserDto $updateUserDto, int $id): AbstractUser
	{
		$user = $this->userModel::find($id);
		$user->update($updateUserDto);
		return $user;
	}

	public function updateImage(string $image, int $id): AbstractUser
	{
		$user = $this->userModel::find($id);
		$user->update([
			"image"=> $image
		]);
		return $user;
	}

	public function updateLocation(UpdateLocationDto $updateLocationDto, int $id): AbstractUser
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
