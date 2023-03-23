<?php

namespace Tests\Feature\User;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowUserFeatureTest extends TestCase
{

	use RefreshDatabase;
	protected $user;
	protected $location;

	public function setUp():void
	{
		parent::setUp();
		$this->user = User::create([
			'name' => 'created-name',
			'email' => 'registered@email.com',
			'password' => '123'
		]);

		$this->location = Location::create([
			'user_id' => $this->user['id'],
			'country' => 'test-country'
		]);

	}

    	public function test_it_should_show_the_user_with_the_informed_id(): void
	{

		$expectedOutput = [
			'user' => [
				'id' => $this->user['id'],
				'name' => $this->user['name'],
				'email' => $this->user['email'],
				'image' => $this->user['image'],
				'description' => $this->user['description'],
				'location' => [
					'id' => $this->location['id'],
					'user_id' => $this->location['user_id'],
					'city' => $this->location['city'],
					'state' => $this->location['state'],
					'country' => $this->location['country']
				]
			]
		];

		$response = $this->json('GET', 'api/user/'.$this->user['id']);

		$data = json_decode($response->getContent(), true);

		$response->assertStatus(200);

		$this->assertEquals($expectedOutput, $data);
	}


	public function test_it_should_return_404_due_to_not_found_user():void
	{
		$response = $this->get('api/user/2');
		$response->assertStatus(404);
	}	
}
