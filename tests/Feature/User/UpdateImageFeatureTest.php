<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateImageFeatureTest extends TestCase{

	use RefreshDatabase;

	protected $user;
	protected $jwt;
	protected $headers;

	public function setUp():void{
		parent::setUp();

		$this->user = User::create([
			'name' => 'test',
			'email' => 'test@gmail.com',
			'password' => Hash::make('123')
		]);

		$this->assertDatabaseHas('users',[
			'id' => $this->user['id'],
			'name' => $this->user['name'],
			'email' => $this->user['email']
		]);

		$this->jwt = JWTAuth::fromUser($this->user);

		$this->headers = ['HTTP_Authorization' => 'Bearer '. $this->jwt];	
	}

	public function test_it_should_updload_the_image_and_save_it_on_the_users_table():void
	{
		$image =  UploadedFile::fake()->image('test.jpg');

		$response = $this->patch('/api/user/image', [
			'image' => $image
		], $this->headers);

		$response->assertStatus(200);

		$this->assertDatabaseHas('users',[
			'id' => $this->user['id'],
			'name' => $this->user['name'],
			'email' => $this->user['email'],
			'image' => 'users/'.$image->hashName()
		]);


		$this->assertTrue(Storage::disk('public')->exists('users/' . $image->hashName()));
		Storage::disk('public')->delete('users/' . $image->hashName());
	}

	public function test_it_should_fail_due_to_lack_of_authentication():void
	{
		$image =  UploadedFile::fake()->image('test.jpg');

		$response = $this->patch('/api/user/image', [
			'image' => $image
		]);

		$response->assertStatus(401);
	}

	public function test_it_should_fail_due_to_file_not_being_a_image():void
	{
		$file =  UploadedFile::fake()->create('test.txt');

		$response = $this->patch('/api/user/image', [
			'image' => $file
		], $this->headers);

		$response->assertStatus(422);

	}

}
