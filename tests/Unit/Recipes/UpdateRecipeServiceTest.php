<?php

namespace Tests\Unit\Recipes;

use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractUpdateRecipe;
use Src\Implementation\Common\Error\ForbiddenError;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Recipes\Dto\UpdateRecipeDto;
use Src\Implementation\Recipes\Services\UpdateRecipeService;
use Tests\TestCase;
use Tests\Unit\TestUser;

class UpdateRecipeServiceTest extends TestCase{

	protected AbstractUpdateRecipe $service;

	public function test_it_should_update_the_recipe_with_the_informed_id():void
	{
		$testRecipe = new TestRecipe();
		$testUser = new TestUser();

		$testUser->id = 1;
		$testRecipe->id = 1;
		$testRecipe->author = $testUser;

		$expectedOutput = new TestRecipe();
		$expectedOutput->id = 1;
		$expectedOutput->author = $testUser;
		$expectedOutput->name = 'updatedName';
		$expectedOutput->timeToPrepare = 'updatedTime';
		$expectedOutput->portions = 2;
		$expectedOutput->difficulty = 2;
		$expectedOutput->ingredients = 'updatedIngredients';
		$expectedOutput->stepsToPrepare = 'updatedStepsToPrepare';

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$recipeRepository->expects($this->once())->method('show')->will($this->returnValue($testRecipe));
		$recipeRepository->expects($this->once())->method('update')->will($this->returnValue($expectedOutput));

		$this->service = new UpdateRecipeService($recipeRepository);

		$updateRecipeDto = new UpdateRecipeDto([
			'name' => 'updatedName',
			'timeToPrepare' => 'updatedTime',
			'portions' => 2,
			'difficulty' => 2,
			'ingredients' => 'updatedIngredients',
			'stepsToPrepare' => 'updatedStepsToPrepare'
		]);

		$result = $this->service->execute($updateRecipeDto, $testRecipe->id, $testUser->id);

		$this->assertEquals($result, $expectedOutput);

	}

	public function test_it_should_fail_due_to_not_found_recipe():void
	{
		$this->expectException(NotFoundError::class);

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(false));

		$this->service = new UpdateRecipeService($recipeRepository);

		$updateRecipeDto = new UpdateRecipeDto([
			'name' => 'updatedName',
			'timeToPrepare' => 'updatedTime',
			'portions' => 2,
			'difficulty' => 2,
			'ingredients' => 'updatedIngredients',
			'stepsToPrepare' => 'updatedStepsToPrepare'
		]);

		$this->service->execute($updateRecipeDto, 2, 1);
	}

	public function test_it_should_faild_due_to_not_being_able_to_update_the_recipe():void
	{
		$this->expectException(ForbiddenError::class);

		$testRecipe = new TestRecipe();
		$testUser = new TestUser();

		$testUser->id = 1;
		$testRecipe->id = 1;
		$testRecipe->author = $testUser;

		$expectedOutput = new TestRecipe();
		$expectedOutput->id = 1;
		$expectedOutput->author = $testUser;

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$recipeRepository->expects($this->once())->method('show')->will($this->returnValue($testRecipe));

		$this->service = new UpdateRecipeService($recipeRepository);

		$updateRecipeDto = new UpdateRecipeDto([
			'name' => 'updatedName',
			'timeToPrepare' => 'updatedTime',
			'portions' => 2,
			'difficulty' => 2,
			'ingredients' => 'updatedIngredients',
			'stepsToPrepare' => 'updatedStepsToPrepare'
		]);

		$userId = 2;

		$this->service->execute($updateRecipeDto, $testRecipe->id, $userId);
	}

}
