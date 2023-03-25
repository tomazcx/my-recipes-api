<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateUserFeatureTest extends TestCase{

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

	public function test_it_should_update_the_user_data():void
	{	
		$response = $this->put('/api/user', [
			'name' => 'updated-name',
			'email' => 'updated@gmail.com',
			'description' => 'updated-description'
		], $this->headers);

		$response->assertStatus(200);
		$this->assertDatabaseHas('users', [
			'name' => 'updated-name',
			'email' => 'updated@gmail.com',
			'description' => 'updated-description'
		]);
	}

	public function test_it_should_fail_due_to_lack_of_authentication():void
	{
		$response = $this->put('/api/user', [
			'name' => 'updated-name',
			'email' => 'updated@gmail.com',
			'description' => 'updated-description'
		]);

		$response->assertStatus(401);
	}

	public function test_it_should_fail_due_to_body_data_not_valid():void
	{
		$response = $this->put('/api/user', [
			'name' => 'updated-name',
			'email' => 'updated-wrong-format',
			'description' => 'updated-description'
		], $this->headers);

		$response->assertStatus(422);
	}

}
