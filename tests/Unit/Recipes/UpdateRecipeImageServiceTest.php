<?php

namespace Tests\Unit\Recipes;

use Illuminate\Support\Facades\Storage;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractUpdateRecipeImage;
use Src\Implementation\Common\Error\ForbiddenError;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Recipes\Services\UpdateRecipeImageService;
use Tests\TestCase;
use Tests\Unit\TestUser;

class UpdateRecipeImageServiceTest extends TestCase{

	protected AbstractUpdateRecipeImage $service;

	public function test_it_should_update_the_recipe_image():void
	{
		Storage::disk('public')->put('tests/example.txt', 'content-example');
		$this->assertTrue(Storage::disk('public')->exists('tests/example.txt'));

		$testRecipe = new TestRecipe();
		$testUser = new TestUser();

		$testUser->id = 1;
		$testRecipe->id = 1;
		$testRecipe->author = $testUser;
		$testRecipe->image = 'tests/example.txt';

		$expectedOutput = new TestRecipe();
		$expectedOutput->id = 1;
		$expectedOutput->author = $testUser;
		$expectedOutput->image = 'tests/test.jpg';

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(true));
		$recipeRepository->expects($this->once())->method('show')->will($this->returnValue($testRecipe));
		$recipeRepository->expects($this->once())->method('updateImage')->will($this->returnValue($expectedOutput));

		$this->service = new UpdateRecipeImageService($recipeRepository);

		$result = $this->service->execute('tests/test.jpg', $testRecipe->id, $testUser->id);

		$this->assertEquals($result, $expectedOutput);
		$this->assertFalse(Storage::disk('public')->exists($testRecipe->image));

	}

	public function test_it_should_fail_due_to_not_found_recipe():void{
		$this->expectException(NotFoundError::class);

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('exists')->will($this->returnValue(false));

		$this->service = new UpdateRecipeImageService($recipeRepository);

		$recipeId = 1;
		$userId = 1;

		$this->service->execute('tests/test.jpg', $recipeId, $userId);
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
		
		$this->service = new UpdateRecipeImageService($recipeRepository);

		$recipeId = 1;
		$userId = 1;

		$this->service->execute('tests/test.jpg', $recipeId, $userId);

	}

}
