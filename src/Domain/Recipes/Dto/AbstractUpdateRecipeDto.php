<?php

namespace Src\Domain\Recipes\Dto;

abstract class AbstractUpdateRecipeDto{

	public ?string $name;
	public ?string $timeToPrepare;
	public ?int $portions;
	public ?int $difficulty;
	public ?string $ingredients;
	public ?string $stepsToPrepare;

}
