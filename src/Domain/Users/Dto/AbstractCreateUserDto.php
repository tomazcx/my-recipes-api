<?php

namespace Src\Domain\Users\Dto;

abstract class AbstractCreateUserDto{

	public string $name;
	public string $email;
	public string $password;
	public string $confirmPassword;
	public ?string $description;
	public ?string $city;
	public ?string $state;
	public string $country;	

}

