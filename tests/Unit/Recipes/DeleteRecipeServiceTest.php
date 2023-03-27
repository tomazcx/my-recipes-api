<?php

namespace Tests\Unit\Recipes;

use Illuminate\Support\Facades\Storage;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractDeleteRecipe;
use Src\Implementation\Common\Error\ForbiddenError;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Recipes\Services\DeleteRecipeService;
use Tests\TestCase;
use Tests\Unit\TestUser;

class DeleteRecipeServiceTest extends TestCase{

	protected AbstractDeleteRecipe $service;

	public function test_it_should_delete_the_recipe_with_the_informed_id():void
	{
		Storage::disk('public')->put('tests/example.txt', 'content-example');
		$this->assertTrue(Storage::disk('public')->exists('tests/example.txt'));

		$testRecipe = new TestRecipe();
		$testUser = new TestUser();

		$testUser->id = 1;
		$testRecipe->author = $testUser;
		$testRecipe->image = 'tests/example.txt';

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$recipeRepository->expects($this->once())->method('show')->will($this->returnValue($testRecipe));
		$recipeRepository->expects($this->once())->method('delete');

		$this->service = new DeleteRecipeService($recipeRepository);

		$recipeId = 1;

		$this->service->execute($recipeId, $testUser->id);
		$this->assertFalse(Storage::disk('public')->exists($testRecipe->image));
	}

	public function test_it_should_fail_due_to_not_found_recipe():void
	{
		$this->expectException(NotFoundError::class);

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(false));

		$this->service = new DeleteRecipeService($recipeRepository);

		$recipeId = 1;
		$userId = 1;

		$this->service->execute($recipeId, $userId);
	}

	public function test_it_should_fail_due_to_user_not_being_allowed_to_delete_the_recipe():void
	{
		$this->expectException(ForbiddenError::class);
	
		$testRecipe = new TestRecipe();
		$testUser = new TestUser();

		$testUser->id = 2;
		$testRecipe->author = $testUser;

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$recipeRepository->expects($this->once())->method('show')->will($this->returnValue($testRecipe));
		
		$this->service = new DeleteRecipeService($recipeRepository);

		$recipeId = 1;

		$this->service->execute($recipeId, 1);	
	}

}
