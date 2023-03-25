<?php

namespace Tests\Unit;

use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractUpdateLocation;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Users\Services\UpdateLocationService;
use Src\Implementation\Users\Dto\UpdateLocationDto;
use Tests\TestCase;

class UpdateLocationServiceTest extends TestCase{

	protected AbstractUpdateLocation $service;

	public function test_it_should_update_the_user_location():void
	{
		$expectedOutput = new TestUser();
		$expectedOutput->id = 1;
		$expectedOutput->name = 'test-name';
		$expectedOutput->email = 'test-email';

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);

		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$userRepository->expects($this->once())->method('updateLocation')->will($this->returnValue($expectedOutput));

		$this->service = new UpdateLocationService($userRepository);

		$updateLocationDto = new UpdateLocationDto([
			'city' => 'test-city',
			'state' => 'test-state',
			'country' => 'test-country'
		]);

		$result = $this->service->execute($updateLocationDto, 1);

		$this->assertEquals($expectedOutput, $result);
	}

	public function test_it_should_fail_due_to_not_found_user():void
	{
		$this->expectException(NotFoundError::class);

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);

		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(false));
		
		$this->service = new UpdateLocationService($userRepository);

		$updateLocationDto = new UpdateLocationDto([
			'city' => 'test-city',
			'state' => 'test-state',
			'country' => 'test-country'
		]);

		$result = $this->service->execute($updateLocationDto, 1);
	}

}
