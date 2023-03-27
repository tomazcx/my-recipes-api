<?php

namespace Src\Implementation\Recipes\Dto;

use Src\Domain\Recipes\Dto\AbstractUpdateRecipeDto;

class UpdateRecipeDto extends AbstractUpdateRecipeDto{

	public function __construct($data)
	{
		$this->name = $data['name']?? null;
		$this->timeToPrepare = $data['timeToPrepare']?? null;
		$this->portions = $data['portions']?? null;
		$this->difficulty = $data['difficulty']?? null;
		$this->ingredients = $data['ingredients']?? null;
		$this->stepsToPrepare = $data['stepsToPrepare']?? null;
	}

}
