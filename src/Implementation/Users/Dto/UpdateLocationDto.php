<?php

namespace Src\Implementation\Users\Dto;

use Src\Domain\Users\Dto\AbstractUpdateLocationDto;

class UpdateLocationDto extends AbstractUpdateLocationDto{

	public function __construct($data)
	{
		$this->city = $data['city']?? null;
		$this->state = $data['state']?? null;
		$this->country = $data['country']?? null;
	}

}
