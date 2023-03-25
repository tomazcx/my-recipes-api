<?php

namespace Src\Implementation\Users\Services;

use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractDeleteUser;
use Src\Implementation\Common\Error\NotFoundError;

class DeleteUserService extends AbstractDeleteUser{

	protected AbstractUserRepository $userRepository;

	public function __construct(AbstractUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;	
	}

	public function execute(int $id): void
	{
		$userExists = $this->userRepository->exists($id);

		if(!$userExists){
			throw new NotFoundError('Usuário não encontrado');
		}

		$this->userRepository->delete($id);
	}

}
