<?php

namespace Tests\Unit\Recipes;

use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractShowRecipe;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Recipes\Services\ShowRecipeService;
use Tests\TestCase;

class ShowRecipeServiceTest extends TestCase{

	protected AbstractShowRecipe $service;

	public function test_it_should_show_the_recipe_with_the_informed_id():void
	{
		$expectedOutput = new TestRecipe();

		$expectedOutput->id = 1;
		$expectedOutput->name = 'test-name';
		$expectedOutput->image = 'test.jpg';

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$recipeRepository->expects($this->once())->method('show')->will($this->returnValue($expectedOutput));

		$this->service = new ShowRecipeService($recipeRepository);

		$result = $this->service->execute(1);

		$this->assertEquals($result, $expectedOutput);
	}

	public function test_it_should_it_should_fail_due_to_not_found_recipe():void
	{
		$this->expectException(NotFoundError::class);

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(false));

		$this->service = new ShowRecipeService($recipeRepository);

		$this->service->execute(1);
	}

}
