<?php

namespace Src\Implementation\Users\Services;

use Src\Domain\Users\Dto\AbstractCreateUserDto;
use Src\Domain\Users\Entities\User;
use Src\Domain\Users\Repositories\IUserRepository;
use Src\Domain\Users\Services\ICreateUser;
use Src\Implementation\Common\Error\InvalidCredentialsError;

class CreateUserService implements ICreateUser{

	protected IUserRepository $userRepository;

	public function __construct(IUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;	
	}

	public function execute(AbstractCreateUserDto $createUserDto): User
	{
		$emailIsRegistered = $this->userRepository->emailExists($createUserDto->email);

		if($emailIsRegistered){
			Throw new InvalidCredentialsError('Email já registrado');
		}

		$user = $this->userRepository->create($createUserDto);

		return $user;
	}
	
}

