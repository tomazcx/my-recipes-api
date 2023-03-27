<?php

namespace Src\Implementation\Recipes\Dto;

use Src\Domain\Recipes\Dto\AbstractCreateRecipeDto;

class CreateRecipeDto extends AbstractCreateRecipeDto{

	public function __construct($data)
	{
		$this->name = $data['name'];
		$this->image = $data['image'];
		$this->timeToPrepare = $data['timeToPrepare'];
		$this->portions = $data['portions'];
		$this->difficulty = $data['difficulty'];
		$this->ingredients = $data['ingredients'];
		$this->stepsToPrepare = $data['stepsToPrepare'];
		$this->categories = $data['categories'];
	}

}
