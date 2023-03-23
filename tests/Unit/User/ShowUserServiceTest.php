<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractShowUser;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Users\Services\ShowUserService;

class ShowUserServiceTest extends TestCase
{
	protected AbstractShowUser $service;		

	public function test_it_should_show_the_user_with_the_informed_id(): void
	{
		//Class being declared at ./CreateUserServiceTest.php
		$user = new TestUser();

		$user->id = 1;
		$user->name ='name';	
		$user->email ='test-email';
		$user->description = 'test';

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);
	
		$userRepository->expects($this->any())->method('exists')->will($this->returnValue(true));
		$userRepository->expects($this->any())->method('show')->will($this->returnValue($user));	

		$service = new ShowUserService($userRepository);	

		$result = $service->execute(1);

		$this->assertSame($result, $user);
	}

	public function test_it_should_fail_due_to_inexistent_id():void
	{
		$this->expectException(NotFoundError::class);

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);
	
		$userRepository->expects($this->any())->method('exists')->will($this->returnValue(false));

		$service = new ShowUserService($userRepository);	

		$result = $service->execute(1);	
	}

}
