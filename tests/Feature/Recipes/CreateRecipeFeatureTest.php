<?php

namespace Tests\Feature\Recipes;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreateRecipeFeatureTest extends TestCase{

	use RefreshDatabase;

	protected $user;
	protected $jwt;
	protected $headers;

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

		Category::create([
			'category' => 'test-category-2'
		]);	

		$this->jwt = JWTAuth::fromUser($this->user);

		$this->headers = ['HTTP_Authorization' => 'Bearer '. $this->jwt];
	}

	public function test_it_should_create_a_recipe():void
	{
		$image =  UploadedFile::fake()->image('test.jpg');

		$response = $this->post('/api/recipe', [
			'name' => 'test-name',
			'image' => $image,
			'timeToPrepare' => 'test-time',
			'portions' => 1,
			'difficulty' => 1,
			'ingredients' => 'test-ingredients',
			'stepsToPrepare' => 'test-steps',
			'categories' => [1, 2]
		], $this->headers);

		$response->assertStatus(201);

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

	public function test_it_fail_due_to_lack_of_authentication():void
	{
		$image =  UploadedFile::fake()->image('test.jpg');

		$response = $this->post('/api/recipe', [
			'name' => 'test-name',
			'image' => $image,
			'timeToPrepare' => 'test-time',
			'portions' => 1,
			'difficulty' => 1,
			'ingredients' => 'test-ingredients',
			'stepsToPrepare' => 'test-steps',
			'categories' => [1, 2]
		]);

		$response->assertStatus(401);

	}

	public function test_it_should_fail_due_to_not_passing_on_form_validation():void
	{

		//not sending required field (image)
		$response = $this->post('/api/recipe', [
			'name' => 'test-name',
			'timeToPrepare' => 'test-time',
			'portions' => 1,
			'difficulty' => 1,
			'ingredients' => 'test-ingredients',
			'stepsToPrepare' => 'test-steps',
			'categories' => [1, 2]
		], $this->headers);

		$response->assertStatus(422);

	}

	public function test_it_should_fail_due_to_not_sending_an_image():void
	{
		$file =  UploadedFile::fake()->create('test.txt');
		
		$response = $this->post('/api/recipe', [
			'name' => 'test-name',
			'timeToPrepare' => 'test-time',
			'image' => $file,
			'portions' => 1,
			'difficulty' => 1,
			'ingredients' => 'test-ingredients',
			'stepsToPrepare' => 'test-steps',
			'categories' => [1, 2]
		], $this->headers);

		$response->assertStatus(422);

	}

}
