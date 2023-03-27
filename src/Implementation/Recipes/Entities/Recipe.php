<?php

namespace Src\Implementation\Recipes\Entities;

use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Implementation\Users\Entities\User;

class Recipe extends AbstractRecipe{

	public function __construct($data)
	{
		$this->id = $data['id'];
		$this->name = $data['name'];
		$this->image = $data['image'];
		$this->timeToPrepare = $data['timeToPrepare'];
		$this->portions = $data['portions'];
		$this->difficulty = $data['difficulty'];
		$this->ingredients = $data['ingredients'];
		$this->stepsToPrepare = $data['stepsToPrepare'];

		if(isset($data['user'])){
			$this->author = new User($data['user']);
		}

		if(isset($data['categories'])){
			$this->categories = $data['categories'];
		}
	}

}
