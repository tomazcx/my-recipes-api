<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Location;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateLocationFeatureTest extends TestCase{

	use RefreshDatabase;

	protected $user;
	protected $location;
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

		$this->location = Location::create([
			'user_id' => $this->user['id'],
			'country' => 'test-country'
		]);	

		$this->assertDatabaseHas('locations', [
			'country' => 'test-country'
		]);

		$this->jwt = JWTAuth::fromUser($this->user);

		$this->headers = ['HTTP_Authorization' => 'Bearer '. $this->jwt];
	}

	public function test_it_should_update_the_user_location():void
	{
		$response = $this->put('/api/user/location', [
			'city' => 'test-city',
			'state' => 'test-state'
		], $this->headers);

		$response->assertStatus(200);
		$this->assertDatabaseHas('locations', [
			'city' => 'test-city',
			'state' => 'test-state',
			'country' => 'test-country'
		]);
	}

	public function test_it_should_fail_due_to_lack_of_authentication():void
	{
		$response = $this->put('/api/user/location', [
			'city' => 'test-city',
			'state' => 'test-state'
		]);

		$response->assertStatus(401);
	}

}
