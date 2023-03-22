<?php

namespace Tests\Unit;

use Src\Domain\Users\Entities\User;
use PHPUnit\Framework\TestCase;
use Src\Domain\Users\Repositories\IUserRepository;
use Src\Domain\Users\Services\ICreateUser;
use Src\Implementation\Users\Dto\CreateUserDto;
use Src\Implementation\Users\Services\CreateUserService;

class TestUser extends User{}

class CreateUserServiceTest extends TestCase
{
	protected ICreateUser $service;	

	public function test_it_should_create_a_new_user(): void
	{

		$user = new TestUser();

		$user->id = 1;
		$user->name ='name';	
		$user->email ='test-email';
		$user->description = 'test';

		$userRepository = $this->getMockForAbstractClass(IUserRepository::class);

		$createUserDto = new CreateUserDto(
			[
				'name' => 'test-name',
				'email' => 'test-email',
				'description' => 'test-description',
				'city' => 'test-city',
				'state' => 'test-state',
				'country' => 'test-country'
			]
		);
	
		$userRepository->expects($this->any())->method('emailExists')->will($this->returnValue(false));
		$userRepository->expects($this->any())->method('create')->will($this->returnValue($user));

		$createUserDto = new CreateUserDto(
			[
				'name' => 'test-name',
				'email' => 'test-email',
				'description' => 'test-description',
				'city' => 'test-city',
				'state' => 'test-state',
				'country' => 'test-country'
			]
		);

		$service = new CreateUserService($userRepository);	

		$result = $service->execute($createUserDto);

		$this->assertSame($result, $user);
	}
}
