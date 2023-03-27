<?php

namespace Tests\Feature\Recipes;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ShowRecipeFeatureTest extends TestCase{

	use RefreshDatabase;

	protected $recipe;

	public function setUp():void
	{
		parent::setUp();

		$user = User::create([
			'name' => 'created-name',
			'email' => 'registered@email.com',
			'password' => '123'
		]);

		$this->assertDatabaseHas('users',[
			'id' => $user['id'],
			'name' => $user['name'],
			'email' => $user['email']
		]);

		Category::create([
			'category' => 'test-category'
		]);	

		$this->recipe = Recipe::create([
			'name' => 'test-name',
			'image' => 'test.jpg',
			'timeToPrepare' => 'test-time',
			'portions' => 4,
			'difficulty' => 1,
			'ingredients' => 'test-ingredients',
			'stepsToPrepare' => 'test-steps',
			'user_id' => $user['id']
		]);

		$this->recipe->categories()->attach([1]);
	}

	public function test_it_should_show_the_recipe_with_the_informed_id():void
	{
		$response = $this->get('/api/recipe/'.$this->recipe['id']);
		$response->assertStatus(200);
	}

	public function test_it_should_return_404_due_to_inexistent_id():void
	{
		$response = $this->get('/api/recipes/2');
		$response->assertStatus(404);
	}



}
