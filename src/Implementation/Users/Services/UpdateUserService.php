<?php

namespace Src\Implementation\Users\Services;

use Src\Domain\Users\Dto\AbstractUpdateUserDto;
use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractUpdateUser;
use Src\Implementation\Common\Error\InvalidCredentialsError;
use Src\Implementation\Common\Error\NotFoundError;

class UpdateUserService extends AbstractUpdateUser{
	
	protected AbstractUserRepository $userRepository;

	public function __construct(AbstractUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;	
	}

	public function execute(AbstractUpdateUserDto $updateUserDto, int $id): AbstractUser
	{
		$userExists = $this->userRepository->exists($id);

		if(!$userExists){
			throw new NotFoundError('Usuário não encontrado');
		}

		$userData = $this->userRepository->show($id);

		//avoids updating the user's email with an already registered email.
		if($updateUserDto->email != null && $userData->email !== $updateUserDto->email){

			$emailIsRegisted = $this->userRepository->emailExists($updateUserDto->email);
	
			if($emailIsRegisted){
				throw new InvalidCredentialsError('Email já registrado. Escolha outro email');
			}
		}

		$updatedUser = $this->userRepository->update($updateUserDto, $id);

		return $updatedUser;
	}

}
