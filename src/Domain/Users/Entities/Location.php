<?php

namespace Src\Domain\Users\Entities;

interface Location{

	public int $id;
	public int $user_id;
	public ?string $city;
	public ?string $state;
	public string $country;

}
