<?php

namespace Tests\Feature\Recipes;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateRecipeFeatureTest extends TestCase{

	use RefreshDatabase;

	protected $recipe;
	protected $headers;
	protected $user;

	public function setUp():void
	{
		parent::setUp();

		$this->user = User::create([
			'name' => 'created-name',
			'email' => 'registered@email.com',
			'password' => '123'
		]);

		$this->assertDatabaseHas('users',[
			'id' => $this->user['id'],
			'name' => $this->user['name'],
			'email' => $this->user['email']
		]);

		Category::create([
			'category' => 'test-category'
		]);	

		$this->recipe = Recipe::create([
			'name' => 'test-name',
			'image' => 'test.jpg',
			'timeToPrepare' => 'test-time',
			'portions' => 1,
			'difficulty' => 1,
			'ingredients' => 'test-ingredients',
			'stepsToPrepare' => 'test-steps',
			'user_id' => $this->user['id']
		]);

		$this->recipe->categories()->attach([1]);

		$jwt = JWTAuth::fromUser($this->user);

		$this->headers = ['HTTP_Authorization' => 'Bearer '. $jwt];
	}

	public function test_it_should_update_the_recipe():void
	{
		$response = $this->put('/api/recipe/'.$this->recipe['id'], [
			'name' => 'updatedName',
			'timeToPrepare' => 'updatedTime',
			'portions' => 2,
			'difficulty' => 2,
			'ingredients' => 'updatedIngredients',
			'stepsToPrepare' => 'updatedStepsToPrepare'
		], $this->headers);

		$response->assertStatus(200);

		$this->assertDatabaseHas('recipes', [
			'name' => 'updatedName',
			'timeToPrepare' => 'updatedTime',
			'portions' => 2,
			'difficulty' => 2,
			'ingredients' => 'updatedIngredients',
			'stepsToPrepare' => 'updatedStepsToPrepare'
		]);
	}

	public function test_should_return_404_not_found_recipe():void
	{
		$response = $this->put('/api/recipe/4', [
			'name' => 'updatedName',
			'timeToPrepare' => 'updatedTime',
			'portions' => 2,
			'difficulty' => 2,
			'ingredients' => 'updatedIngredients',
			'stepsToPrepare' => 'updatedStepsToPrepare'
		], $this->headers);

		$response->assertStatus(404);
	}

	public function test_it_should_return_403_forbidden_when_trying_to_update_another_user_recipe():void{

		$second_user = User::create([
			'name' => 'created-name',
			'email' => 'second@email.com',
			'password' => '123'
		]);

		$this->assertDatabaseHas('users',[
			'id' => $second_user['id'],
			'name' => $second_user['name'],
			'email' => $second_user['email']
		]);

		Category::create([
			'category' => 'test-category-2'
		]);	

		$second_recipe = Recipe::create([
			'name' => 'test-name',
			'image' => 'test.jpg',
			'timeToPrepare' => 'test-time',
			'portions' => 4,
			'difficulty' => 1,
			'ingredients' => 'test-ingredients',
			'stepsToPrepare' => 'test-steps',
			'user_id' => $second_user['id']
		]);
		
		$second_recipe->categories()->attach([2]);

		$response = $this->put('/api/recipe/'.$second_recipe['id'], [
			'name' => 'updatedName',
			'timeToPrepare' => 'updatedTime',
			'portions' => 2,
			'difficulty' => 2,
			'ingredients' => 'updatedIngredients',
			'stepsToPrepare' => 'updatedStepsToPrepare'
		], $this->headers);

		$response->assertStatus(403);
	}

	public function test_it_should_fail_due_to_lack_of_authentication():void
	{
		$response = $this->put('/api/recipe/'.$this->recipe['id'], [
			'name' => 'updatedName',
			'timeToPrepare' => 'updatedTime',
			'portions' => 2,
			'difficulty' => 2,
			'ingredients' => 'updatedIngredients',
			'stepsToPrepare' => 'updatedStepsToPrepare'
		]);

		$response->assertStatus(401);
	}
}
