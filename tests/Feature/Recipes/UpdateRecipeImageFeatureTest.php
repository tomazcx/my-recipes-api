<?php

namespace Tests\Feature\Recipes;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateRecipeImageFeatureTest extends TestCase{

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

	public function test_it_should_update_the_recipe_image():void
	{
		$image =  UploadedFile::fake()->image('test.jpg');

		$response = $this->patch('/api/recipe/image/'.$this->recipe['id'], [
			'image' => $image
		], $this->headers);

		$response->assertStatus(200);

		$this->assertDatabaseHas('recipes', [
		       	'name' => 'test-name',
			'image' => 'recipes/'.$image->hashName(),
			'user_id' => $this->user['id'],
			'timeToPrepare' => 'test-time',
			'portions' => 1,
			'difficulty' => 1,
			'ingredients' => 'test-ingredients',
			'stepsToPrepare' => 'test-steps'
		]);

		$this->assertTrue(Storage::disk('public')->exists('recipes/' . $image->hashName()));
		Storage::disk('public')->delete('recipes/' . $image->hashName());

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

		$image =  UploadedFile::fake()->image('test2.jpg');

		$response = $this->patch('/api/recipe/image/'.$second_recipe['id'], [
			'image' => $image
		], $this->headers);

		$response->assertStatus(403);

		$this->assertFalse(Storage::disk('public')->exists('recipes/' . $image->hashName()));


	}

	public function test_it_should_return_404_not_found_recipe():void
	{
		$image =  UploadedFile::fake()->image('test3.jpg');

		$response = $this->patch('/api/recipe/image/4', [
			'image' => $image
		], $this->headers);

		$response->assertStatus(404);

		$this->assertFalse(Storage::disk('public')->exists('recipes/' . $image->hashName()));

	}

	public function test_it_should_fail_due_to_lack_of_authentication():void{
		$image =  UploadedFile::fake()->image('test.jpg');

		$response = $this->patch('/api/recipe/image/4', [
			'image' => $image
		]);

		$response->assertStatus(401);
	}

}
