<?php

namespace Tests\Feature\Comment;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreateCommentFeatureTest extends TestCase{

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

	public function test_it_should_return_201_created_comment():void
	{
		$response = $this->post('/api/comment/'.$this->recipe['id'], [
			'content' => 'test'
		], $this->headers);

		$response->assertStatus(201);

		$this->assertDatabaseHas('comments', [
			'content' => 'test',
			'user_id' => $this->user['id'],
			'recipe_id' => $this->recipe['id']
		]);
	}

	public function test_it_should_return_404_not_found_recipe():void
	{
		$response = $this->post('/api/comment/2', [
			'content' => 'test'
		], $this->headers);

		$response->assertStatus(404);

	}

	public function test_it_should_return_422_unprocessable_entity():void
	{
		$response = $this->post('/api/comment/'.$this->recipe['id'], [], $this->headers);

		$response->assertStatus(422);
	}

	public function test_it_should_fail_due_to_lack_of_authentication():void
	{
		$response = $this->post('/api/comment/'.$this->recipe['id'], [
			'comment' => 'test'
		]);

		$response->assertStatus(401);

	}



}
