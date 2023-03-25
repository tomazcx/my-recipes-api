<?php

namespace Src\Domain\Users\Dto;

abstract class AbstractUpdateUserDto{

	public ?string $name;
	public ?string $email;
	public ?string $description;
}

