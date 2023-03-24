<?php

namespace Src\Domain\Auth\Services;

use Src\Domain\Auth\Dto\AbstractAuthenticateDto;
use Src\Domain\Auth\Entities\AbstractAuthToken;

abstract class AbstractAuthenticate {

	abstract function execute(AbstractAuthenticateDto $createndials):AbstractAuthToken;

}
