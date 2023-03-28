<?php

namespace Tests\Feature\Comment;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;


class ShowRecipeCommentsFeatureTest extends TestCase{

	use RefreshDatabase;

	protected $recipe;
	protected $comment;
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

		$this->comment = Comment::create([
			'content' => 'test',
			'user_id' => $this->user['id'],
			'recipe_id' => $this->recipe['id']
		]);

		$this->assertDatabaseHas('comments', [
			'content' => 'test',
			'user_id' => $this->user['id'],
			'recipe_id' => $this->recipe['id']
		]);
	}

	public function test_it_should_show_return_200_recipe_comments():void
	{
		$response = $this->get('/api/comment/recipe/'.$this->recipe['id']);	

		$response->assertStatus(200);

		$content = $response->decodeResponseJson();

		$this->assertEquals($content[0]['id'], $this->comment['id']);
	}

	public function test_it_should_return_404_not_found_recipe():void
	{
		$response = $this->get('/api/comment/recipe/2');	

		$response->assertStatus(404);
	}
	

}
