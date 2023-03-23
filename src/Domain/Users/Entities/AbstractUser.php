<?php

namespace Src\Domain\Users\Entities;

use Src\Domain\Users\Entities\AbstractLocation;

abstract class AbstractUser {

	public int $id;
	public string $name;
	public string $email;
	public ?string $image;
	public ?string $description;
	public AbstractLocation $location;

}
