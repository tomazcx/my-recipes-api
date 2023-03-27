<?php

namespace Tests\Unit\Recipes;

use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use Src\Domain\Recipes\Services\AbstractCreateRecipe;
use Src\Domain\Users\Repositories\AbstractUserRepository;
use Src\Implementation\Common\Error\NotFoundError;
use Src\Implementation\Recipes\Dto\CreateRecipeDto;
use Src\Implementation\Recipes\Services\CreateRecipeService;
use Tests\TestCase;

class TestRecipe extends AbstractRecipe{};

class CreateRecipeServiceTest extends TestCase{

	protected AbstractCreateRecipe $service;

	public function test_it_should_create_a_new_recipe():void
	{
		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);
		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(true));

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);
		$recipeRepository->expects($this->once())->method('create')->will($this->returnValue(new TestRecipe));

		$service = new CreateRecipeService($userRepository, $recipeRepository);

		$createRecipeDto = new CreateRecipeDto([
			'name' => 'test-name',
			'image' => 'test.jpg',
			'timeToPrepare' => 'test-time',
			'portions' => 4,
			'difficulty' => 1,
			'ingredients' => 'test-ingredients',
			'stepsToPrepare' => 'test-steps',
			'categories' => [1, 2],
			'authorId' => 1
		]);

		$result = $service->execute($createRecipeDto, 1);
	}

	public function test_it_should_fail_due_to_not_found_user():void
	{
		$this->expectException(NotFoundError::class);

		$userRepository = $this->getMockForAbstractClass(AbstractUserRepository::class);
		$userRepository->expects($this->once())->method('exists')->will($this->returnValue(false));

		$recipeRepository = $this->getMockForAbstractClass(AbstractRecipeRepository::class);

		$service = new CreateRecipeService($userRepository, $recipeRepository);

		$createRecipeDto = new CreateRecipeDto([
			'name' => 'test-name',
			'image' => 'test.jpg',
			'timeToPrepare' => 'test-time',
			'portions' => 4,
			'difficulty' => 1,
			'ingredients' => 'test-ingredients',
			'stepsToPrepare' => 'test-steps',
			'categories' => [1, 2],
			'authorId' => 1
		]);

		$service->execute($createRecipeDto, 1);


	}

}
