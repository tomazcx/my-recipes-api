<?php

namespace Src\Implementation\Users\Services;

use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractShowUser;
use Src\Implementation\Common\Error\NotFoundError;

class ShowUserService extends AbstractShowUser{

	protected AbstractUserRepository $userRepository;

	public function __construct(AbstractUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;	
	}

	public function execute(int $id): AbstractUser
	{
		$userExists = $this->userRepository->exists($id);

		if(!$userExists){
			Throw new NotFoundError('Usuário não encontrado');
		}

		$user = $this->userRepository->show($id);

		return $user;
	}

}
