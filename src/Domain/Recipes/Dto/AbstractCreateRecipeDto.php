<?php

namespace Src\Domain\Recipes\Dto;

abstract class AbstractCreateRecipeDto{

	public string $name;
	public string $image;
	public string $timeToPrepare;
	public int $portions;
	public int $difficulty;
	public string $ingredients;
	public string $stepsToPrepare;
	public int $authorId;
	public array $categories;

}
