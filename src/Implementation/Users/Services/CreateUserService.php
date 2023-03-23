<?php

namespace Src\Implementation\Users\Services;

use Illuminate\Support\Facades\Hash;
use Src\Domain\Users\Dto\AbstractCreateUserDto;
use Src\Domain\Users\Entities\AbstractUser;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Domain\Users\Services\AbstractCreateUser;
use Src\Implementation\Common\Error\InvalidCredentialsError;

class CreateUserService extends AbstractCreateUser{

	protected AbstractUserRepository $userRepository;

	public function __construct(AbstractUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;	
	}

	public function execute(AbstractCreateUserDto $createUserDto): AbstractUser
	{

		if($createUserDto->password != $createUserDto->confirmPassword){
			Throw new InvalidCredentialsError('Senha e confirmar senha precisam ser iguais');
		}

		$emailIsRegistered = $this->userRepository->emailExists($createUserDto->email);

		if($emailIsRegistered){
			Throw new InvalidCredentialsError('Email já registrado');
		}

		$createUserDto->password = Hash::make($createUserDto->password, [
			'rounds' => 12
		]);

		$user = $this->userRepository->create($createUserDto);

		return $user;
	}
	
}

