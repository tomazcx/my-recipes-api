<?php

namespace Tests\Unit\Recipes;

use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractShowRecipes;
use Src\Implementation\Recipes\Services\ShowRecipesService;
use Tests\TestCase;

class ShowRecipesServiceTest extends TestCase{

	protected AbstractShowRecipes $service;

	public function test_it_should_show_all_the_recipes():void
	{
		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);

		$recipeRepository->expects($this->once())->method('all')->will($this->returnValue([]));
		$recipeRepository->expects($this->never())->method('showRecipesByCategory');
		$recipeRepository->expects($this->never())->method('showRecipesByName');
		$recipeRepository->expects($this->never())->method('showRecipesByCategoryAndName');

		$this->service = new ShowRecipesService($recipeRepository);

		$name = null;
		$categoryId = null;

		$result = $this->service->execute($name, $categoryId);
	}

	public function test_it_should_show_all_the_recipes_that_matches_a_certain_category():void
	{
		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);

		$recipeRepository->expects($this->never())->method('all');
		$recipeRepository->expects($this->once())->method('showRecipesByCategory')->will($this->returnValue([]));
		$recipeRepository->expects($this->never())->method('showRecipesByName');
		$recipeRepository->expects($this->never())->method('showRecipesByCategoryAndName');

		$this->service = new ShowRecipesService($recipeRepository);

		$name = null;
		$categoryId = 1;

		$result = $this->service->execute($name, $categoryId);
	}

	public function test_it_should_show_all_the_recipes_that_matches_a_certain_name():void
	{
		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);

		$recipeRepository->expects($this->never())->method('all');
		$recipeRepository->expects($this->never())->method('showRecipesByCategory');
		$recipeRepository->expects($this->once())->method('showRecipesByName')->will($this->returnValue([]));
		$recipeRepository->expects($this->never())->method('showRecipesByCategoryAndName');

		$this->service = new ShowRecipesService($recipeRepository);

		$name = 'test';
		$categoryId = null;

		$result = $this->service->execute($name, $categoryId);
	}

	public function test_it_should_show_all_the_recipes_that_matches_a_certain_name_and_category():void
	{
		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);

		$recipeRepository->expects($this->never())->method('all');
		$recipeRepository->expects($this->never())->method('showRecipesByCategory');
		$recipeRepository->expects($this->never())->method('showRecipesByName');
		$recipeRepository->expects($this->once())->method('showRecipesByCategoryAndName')->will($this->returnValue([]));

		$this->service = new ShowRecipesService($recipeRepository);

		$name = 'test';
		$categoryId = 1;

		$result = $this->service->execute($name, $categoryId);
	}

}
