<?php

namespace Src\Domain\Users\Entities;

use Src\Domain\User\Entities\Location;

abstract class User {

	public int $id;
	public string $name;
	public string $email;
	public ?string $image;
	public ?string $description;
	public Location $location;

}
