<?php

namespace Tests\Unit;

use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractUpdateUser;
use Src\Implementation\Common\Error\InvalidCredentialsError;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Users\Services\UpdateUserService;
use Src\Implementation\Users\Dto\UpdateUserDto;
use Tests\TestCase;

class UpdateUserServiceTest extends TestCase{

	protected AbstractUpdateUser $service;

	public function test_it_should_update_the_user_with_the_informed_id():void
	{

		$testData = new TestUser();
		$testData->id = 1;
		$testData->name = 'test-name';
		$testData->email = 'test@gmail.com';

		$expectedOutput = new TestUser();
		$expectedOutput->id = 1;
		$expectedOutput->name = 'updated-name';
		$expectedOutput->email = 'update@gmail.com';
		$expectedOutput->description = 'updated';

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);
		
		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$userRepository->expects($this->once())->method('show')->will($this->returnValue($testData));
		$userRepository->expects($this->once())->method('update')->will($this->returnValue($expectedOutput));
		$userRepository->expects($this->once())->method('emailExists')->will($this->returnValue(false));


		$this->service = new UpdateUserService($userRepository);

		$updateUserDto = new UpdateUserDto([
			'name' => 'updated-name',
			'email' => 'update@gmail.com',
			'description' => 'updated'
		]);

		$result = $this->service->execute($updateUserDto, 1);

		$this->assertEquals($result, $expectedOutput);
	}

	public function test_it_should_throw_a_not_found_error_due_to_not_found_user():void
	{
		$this->expectException(NotFoundError::class);

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);

		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(false));
		
		$this->service = new UpdateUserService($userRepository);

		$updateUserDto = new UpdateUserDto([
			'name' => 'updated-name',
			'email' => 'update@gmail.com',
			'description' => 'updated'
		]);

		$result = $this->service->execute($updateUserDto, 1);

	}

	public function test_it_should_fail_due_to_already_registed_email():void
	{
		$testData = new TestUser();
		$testData->id = 1;
		$testData->name = 'test-name';
		$testData->email = 'test@gmail.com';

		$this->expectException(InvalidCredentialsError::class);

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);

		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$userRepository->expects($this->once())->method('show')->will($this->returnValue($testData));	
		$userRepository->expects($this->once())->method('emailExists')->will($this->returnValue(true));

		$this->service = new UpdateUserService($userRepository);

		$updateUserDto = new UpdateUserDto([
			'name' => 'updated-name',
			'email' => 'update@gmail.com',
			'description' => 'updated'
		]);

		$result = $this->service->execute($updateUserDto, 1);
	}

}
