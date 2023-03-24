<?php

namespace Src\Implementation\Auth\Services;

use Src\Domain\Auth\Dto\AbstractAuthenticateDto;
use Src\Domain\Auth\Entities\AbstractAuthToken;
use Src\Domain\Auth\Services\AbstractAuthenticate;
use Src\Implementation\Auth\Entities;
use Src\Implementation\Auth\Entities\AuthToken;
use Src\Implementation\Common\Error\UnauthorizedError;

class AuthenticateService extends AbstractAuthenticate{

	public function execute(AbstractAuthenticateDto $createndials):AbstractAuthToken
	{
		if(!$token = auth('api')->attempt([
			'email' => $createndials->email,
			'password' => $createndials->password
		])){
			throw new UnauthorizedError('Credenciais inválidas.');
		}

		$authToken = new AuthToken([
			'token' => $token,
			'token_type' => 'bearer'
		]);

		return $authToken;
	}

}
