<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractUpdateImage;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Users\Services\UpdateImageService;
use Tests\TestCase;

class UpdateImageTest extends TestCase{

	protected AbstractUpdateImage $service;

	public function test_it_should_update_the_user_image():void
	{

		$userData = new TestUser();
		$userData->name = 'test-name';
		$userData->email = 'test@gmail.com';
		$userData->image = null;

		$expectedOutput = new TestUser();
		$expectedOutput->name = 'test-name';
		$expectedOutput->email = 'test@gmail.com';
		$expectedOutput->image = 'image.jpg';

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);

		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$userRepository->expects($this->once())->method('show')->will($this->returnValue($userData));
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

	public function test_it_should_delete_the_image_if_defined():void
	{
		Storage::disk('public')->put('tests/example.txt', 'content-example');

		$userData = new TestUser();
		$userData->name = 'test-name';
		$userData->email = 'test@gmail.com';
		$userData->image = 'tests/\example.txt';

		$expectedOutput = new TestUser();
		$expectedOutput->name = 'test-name';
		$expectedOutput->email = 'test@gmail.com';
		$expectedOutput->image = 'image.jpg';

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);

		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$userRepository->expects($this->once())->method('show')->will($this->returnValue($userData));
		$userRepository->expects($this->once())->method('updateImage')->will($this->returnValue($expectedOutput));

		$this->service = new UpdateImageService($userRepository);

		$result = $this->service->execute('image.jpg', 1);

		$this->assertEquals($expectedOutput, $result);

		$this->assertFalse(Storage::disk('public')->exists($userData->image));

	}

}
