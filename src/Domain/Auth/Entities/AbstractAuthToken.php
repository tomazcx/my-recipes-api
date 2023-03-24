<?php

namespace Src\Domain\Auth\Entities;

abstract class AbstractAuthToken{

	public string $token;
	public string $token_type;

}
