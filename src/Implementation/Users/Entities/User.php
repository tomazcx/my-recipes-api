<?php

namespace Src\Implementation\Users\Entities;

use Src\Domain\Users\Entities\AbstractUser;

class User extends AbstractUser{

	public function __construct($data)
	{
		$this->id = $data['id'];
		$this->name = $data['name'];
		$this->email = $data['email'];
		$this->description = $data['description'];
		$this->image = $data['image'];

		if(isset($data['location'])){
			$this->location = new Location($data['location']);
		}
	}

}
