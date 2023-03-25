<?php

namespace Src\Domain\Recipes\Entities;

use Src\Domain\Users\Entities\AbstractUser;

abstract class AbstractRecipe{

	public int $id;
	public string $name;
	public string $image;
	public string $timeToPrepare;
	public int $portions;
	public int $difficulty;
	public string $ingredients;
	public string $stepsToPrepare;
	public AbstractUser $author;

	/**
	 * @var AbatractCategories[]
	 */
	public $categories;



}
