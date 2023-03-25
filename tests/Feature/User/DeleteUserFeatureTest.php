<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class DeleteUserFeatureTest extends TestCase{

	use RefreshDatabase;

	protected $user;
	protected $jwt;
	protected $headers;

	public function setUp():void
	{
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

	public function test_it_should_delete_and_return_204():void
	{
	
		$response = $this->json('DELETE', '/api/user', [], $this->headers);

		$response->assertSuccessful();
		$response->assertStatus(204);
		$this->assertDatabaseMissing('users',[
			'id' => $this->user['id'],
			'name' => $this->user['name'],
			'email' => $this->user['email']
		]);
	}

	public function test_it_should_fail_due_lack_of_authentication():void
	{
		$response = $this->delete('/api/user', []);

		$response->assertStatus(401);

	}

}
