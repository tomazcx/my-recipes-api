<?php

namespace Src\Implementation\Recipes\Repositories;

use App\Models\Recipe as RecipeModel;
use Src\Domain\Recipes\Repositories\AbstractRecipeRepository;
use App\Models\User as UserModel;
use Src\Domain\Recipes\Dto\AbstractCreateRecipeDto;
use Src\Domain\Recipes\Dto\AbstractUpdateRecipeDto;
use Src\Domain\Recipes\Entities\AbstractRecipe;
use Src\Implementation\Recipes\Entities\Recipe;

class RecipeRepository extends AbstractRecipeRepository{

	protected UserModel $usersModel;
	protected RecipeModel $recipesModel;

	public function __construct(UserModel $usersModel, RecipeModel $recipesModel)
	{
		$this->usersModel = $usersModel;	
		$this->recipesModel = $recipesModel;
	}

	public function exists(int $id): bool
	{
		$recipe = $this->recipesModel::find($id);
		return !!$recipe;
	}

	public function show(int $id): AbstractRecipe
	{
		$recipe = $this->recipesModel::with('user', 'categories')->find($id);
		$recipeObj = new Recipe($recipe);
		return $recipeObj;
	}

	public function create(AbstractCreateRecipeDto $createRecipeDto, $userId): AbstractRecipe
	{
		$recipe = $this->recipesModel::create([
			'name' => $createRecipeDto->name,
			'image' => $createRecipeDto->image,
			'timeToPrepare' => $createRecipeDto->timeToPrepare,
			'portions' => $createRecipeDto->portions,
			'difficulty' => $createRecipeDto->difficulty,
			'ingredients' => $createRecipeDto->ingredients,
			'stepsToPrepare' => $createRecipeDto->stepsToPrepare,
			'user_id' => $userId
		]);

		$recipe->categories()->attach($createRecipeDto->categories);

		$recipe = $this->recipesModel::with('user', 'categories')->find($recipe->id);

		$recipeObj = new Recipe($recipe);

		return $recipeObj;
	}

	public function showRecipesByName(string $name): array
	{
		$recipes = $this->recipesModel::where('name', 'LIKE', '%' . $name . '%')->with('categories', 'users')->get();
		return $recipes;
	}

	public function showRecipesByCategory(int $cateogoryId): array
	{
		$recipes = $this->recipesModel::whereHas('categories', function ($query) use ($cateogoryId) {
			$query->find($cateogoryId);
		});	

		return $recipes;
	}

	public function update(AbstractUpdateRecipeDto $updateRecipeDto, int $id): AbstractRecipe
	{
		$recipe = $this->recipesModel::find($id);

		$updatedRecipe = $recipe::update([
			'name' => $updateRecipeDto->name?? $recipe['name'],	
			'timeToPrepare' => $updateRecipeDto->timeToPrepare?? $recipe['timeToPrepare'],
			'portions' => $updateRecipeDto->portions?? $recipe['portions'],
			'difficulty' => $updateRecipeDto->difficulty?? $recipe['difficulty'],
			'ingredients' => $updateRecipeDto->ingredients?? $recipe['ingredients'],
			'stepsToPrepare' => $updateRecipeDto->stepsToPrepare?? $recipe['stepsToPrepare']
		]);
	
		$recipeObj = new Recipe($updatedRecipe);

		return $recipeObj;
	}	

	public function updateImage(string $image, int $id): AbstractRecipe
	{
		$recipe = $this->recipesModel::find($id);

		$updatedRecipe = $recipe::update([
			'image' => $image
		]);
		$recipeObj = new Recipe($updatedRecipe);
		
		return $recipeObj;
	}


	public function delete(int $id): void
	{
		$this->recipesModel::destroy($id);
	}

}
