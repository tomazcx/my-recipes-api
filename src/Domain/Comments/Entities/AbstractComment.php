<?php

namespace Src\Domain\Comments\Entities;

use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Domain\Users\Entities\AbstractUser;

abstract class AbstractComment{

	public int $id;
	public string $content;
	public AbstractUser $author;
	public ?AbstractRecipe $recipe;

}
