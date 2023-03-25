<?php

namespace Src\Implementation\Users\Services;

use Src\Domain\Users\Dto\AbstractUpdateLocationDto;
use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractUpdateLocation;
use Src\Implementation\Common\Error\NotFoundError;

class UpdateLocationService extends AbstractUpdateLocation{

	protected AbstractUserRepository $userRepository;

	public function __construct(AbstractUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;	
	}

	public function execute(AbstractUpdateLocationDto $updateLocationDto, int $id): AbstractUser
	{
		$userExists = $this->userRepository->exists($id);

		if(!$userExists){
			throw new NotFoundError('Usuário não encontrado');
		}

		$user = $this->userRepository->updateLocation($updateLocationDto, $id);

		return $user;
	}

}
