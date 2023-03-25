<?php

namespace Tests\Unit;

use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractUpdateImage;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Users\Services\UpdateImageService;
use Tests\TestCase;

class UpdateImageTest extends TestCase{

	protected AbstractUpdateImage $service;

	public function test_it_should_update_the_user_image():void
	{
		$expectedOutput = new TestUser();

		$expectedOutput->name = 'test-name';
		$expectedOutput->email = 'test@gmail.com';
		$expectedOutput->image = 'image.jpg';

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);

		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$userRepository->expects($this->once())->method('updateImage')->will($this->returnValue($expectedOutput));

		$this->service = new UpdateImageService($userRepository);

		$result = $this->service->execute('image.jpg', 1);

		$this->assertEquals($expectedOutput, $result);
	}

	public function test_it_should_fail_due_to_not_found_user():void
	{
		$this->expectException(NotFoundError::class);

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);

		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(false));
		
		$this->service = new UpdateImageService($userRepository);

		$result = $this->service->execute('image.jpg', 1);

	}

}
