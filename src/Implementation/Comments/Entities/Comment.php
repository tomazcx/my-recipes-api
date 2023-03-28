<?php

namespace Src\Implementation\Comments\Entities;

use Src\Domain\Comments\Entities\AbstractComment;
use Src\Implementation\Users\Entities\User;
use Src\Implementation\Recipes\Entities\Recipe;


class Comment extends AbstractComment{

	public function __construct($data)
	{
		$this->id = $data['id'];
		$this->content = $data['content'];

		if(isset($data['user'])){
			$this->author = new User($data['user']);
		}

		if(isset($data['recipe'])){
			$this->recipe = new Recipe($data['recipe']);
		}
	}

}
