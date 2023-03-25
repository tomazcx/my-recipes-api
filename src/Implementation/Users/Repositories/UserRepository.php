<?php


namespace Src\Implementation\Users\Repositories;

use App\Models\Location as LocationModel;
use App\Models\User as UserModel;
use Src\Domain\Users\Dto\AbstractCreateUserDto;
use Src\Domain\Users\Dto\AbstractUpdateLocationDto;
use Src\Domain\Users\Dto\AbstractUpdateUserDto;
use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Implementation\Users\Entities\Location;
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

		$location->user()->associate($user);
		$location->save();

		$user['location'] = [
			'id' => $location->id,
			'user_id' => $location->user_id,
			'city' => $location->city,
			'state' => $location->state,
			'country' => $location->country
		];

		$userObj = new User($user);

		return $userObj;
	}

	public function update(AbstractUpdateUserDto $updateUserDto, int $id): AbstractUser
	{
		$user = $this->userModel::find($id);

		$user->update([
			'name' => $updateUserDto->name?? $user['name'],
			'email' => $updateUserDto->email?? $user['email'],
			'description' => $updateUserDto->description
		]);

		$userObj = new User($user);

		return $userObj;
	}

	public function updateImage(string $image, int $id): AbstractUser
	{
		$user = $this->userModel::find($id);
		$user->update([
			"image"=> $image
		]);

		$userObj = new User($user);
		return $userObj;
	}

	public function updateLocation(AbstractUpdateLocationDto $updateLocationDto, int $id): AbstractUser
	{	
		$location = $this->locationModel::where('user_id', $id)->first();

		$location->update([
			'city' => $updateLocationDto->city?? $location['city'],
			'state' => $updateLocationDto->state?? $location['state'],
			'country' => $updateLocationDto->country?? $location['country']
		]);

		$user = $this->userModel::with('location')->find($id);

		$userObj = new User($user);

		return $userObj;
	}

	public function delete(int $id): void
	{
		$this->userModel::destroy($id);
	}
	
	

}
