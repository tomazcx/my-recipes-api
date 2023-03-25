<?php

namespace Tests\Unit;

use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractDeleteUser;
use Src\Implementation\Users\Services\DeleteUserService;
use Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Implementation\Common\Error\NotFoundError;

class DeleteUserServiceTest extends TestCase{

	protected AbstractDeleteUser $service;

	public function test_it_should_delete_a_user_with_the_informed_id(){
		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);

		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$userRepository->expects($this->once())->method('delete');

		$this->service = new DeleteUserService($userRepository);

		$this->service->execute(1);
	}

	public function test_it_should_fail_due_to_inexistent_id(){

		$this->expectException(NotFoundError::class);

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);

		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(false));

		$this->service = new DeleteUserService($userRepository);

		$this->service->execute(1);
	}

}
