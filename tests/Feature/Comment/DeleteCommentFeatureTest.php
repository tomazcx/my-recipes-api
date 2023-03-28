<?php

namespace Tests\Feature\Comment;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;
use Tymon\JWTAuth\Facades\JWTAuth;

class DeleteCommentFeatureTest extends TestCase{

	use RefreshDatabase;

	protected $recipe;
	protected $comment;
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

		$jwt = JWTAuth::fromUser($this->user);

		$this->headers = ['HTTP_Authorization' => 'Bearer '. $jwt];
	}

	public function test_it_should_return_204_deleted_comment():void
	{
		$response = $this->delete('/api/comment/'.$this->comment['id'], [], $this->headers);

		$response->assertStatus(204);

		$this->assertDatabaseMissing('comments', [
			'content' => 'test',
			'user_id' => $this->user['id'],
			'recipe_id' => $this->recipe['id']
		]);
	}

	public function test_it_should_return_404_not_found_comment():void
	{
		$response = $this->delete('/api/comment/2', [], $this->headers);

		$response->assertStatus(404);
	}

	public function test_it_should_return_403_forbidden():void
	{
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

		$second_comment = Comment::create([
			'content' => 'test',
			'user_id' => $second_user['id'],
			'recipe_id' => $second_recipe['id']
		]);

		$response = $this->delete('/api/comment/'.$second_comment['id'], [], $this->headers);

		$response->assertStatus(403);
	}

	public function it_should_fail_due_to_lack_of_authentication():void
	{
		$response = $this->delete('/api/comment/'.$this->comment['id']);

		$response->assertStatus(401);
	}

}
