<?php

namespace Src\Implementation\Users\Entities;

use Src\Domain\Users\Entities\AbstractLocation;

class Location extends AbstractLocation{

	public function __construct($data)
	{
		$this->id = $data['id'];
		$this->user_id = $data['user_id'];
		$this->city = $data['city'];
		$this->state = $data['state'];
		$this->country = $data['country'];
	}

}
