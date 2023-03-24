<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\TestCase;
use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractCreateUser;
use Src\Implementation\Common\Error\InvalidCredentialsError;
use Src\Implementation\Users\Dto\CreateUserDto;
use Src\Implementation\Users\Services\CreateUserService;

class TestUser extends AbstractUser{}

class CreateUserServiceTest extends TestCase
{
	protected AbstractCreateUser $service;	

	public function test_it_should_create_a_new_user(): void
	{
		$user = new TestUser();

		$user->id = 1;
		$user->name ='name';	
		$user->email ='test-email';
		$user->description = 'test';

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);
	
		$userRepository->expects($this->any())->method('emailExists')->will($this->returnValue(false));
		$userRepository->expects($this->any())->method('create')->will($this->returnValue($user));

		Hash::shouldReceive('make')->once()->with('123', ['rounds' => 12])->andReturn('hashedpassword');

		$createUserDto = new CreateUserDto(
			[
				'name' => 'test-name',
				'email' => 'test-email',
				'password' => '123',
				'confirmPassword' => '123',
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

	public function test_it_should_fail_due_to_existent_email():void
	{
		$this->expectException(InvalidCredentialsError::class);

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);
	
		$userRepository->expects($this->any())->method('emailExists')->will($this->returnValue(true));

		$createUserDto = new CreateUserDto(
			[
				'name' => 'test-name',
				'email' => 'test-email',
				'password' => '123',
				'confirmPassword' => '123',
				'description' => 'test-description',
				'city' => 'test-city',
				'state' => 'test-state',
				'country' => 'test-country'
			]
		);

		$service = new CreateUserService($userRepository);	

		$result = $service->execute($createUserDto);	
	}

	public function test_it_should_fail_due_to_different_passwords():void
	{
		$this->expectException(InvalidCredentialsError::class);

		$createUserDto = new CreateUserDto(
			[
				'name' => 'test-name',
				'email' => 'test-email',
				'password' => '123',
				'confirmPassword' => '1234',
				'description' => 'test-description',
				'city' => 'test-city',
				'state' => 'test-state',
				'country' => 'test-country'
			]
		);

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);

		$service = new CreateUserService($userRepository);	

		$result = $service->execute($createUserDto);	
		
	}
}
