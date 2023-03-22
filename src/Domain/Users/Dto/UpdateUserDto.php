<?php

namespace Src\Domain\Users\Dto;

interface UpdateUserDto{

	public ?string $name;
	public ?string $email;
	public ?string $description;
}

