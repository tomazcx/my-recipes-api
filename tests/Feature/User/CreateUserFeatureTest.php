<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserFeatureTest extends TestCase
{

	use RefreshDatabase;

    	public function test_it_should_create_a_user(): void
	{
	    $response = $this->post('api/user', [
				'name' => 'test-name',
				'email' => 'test@gmail.com',
				'password' => '123',
				'confirmPassword' => '123',
				'description' => 'test-description',
				'city' => 'test-city',
				'state' => 'test-state',
				'country' => 'test-country'
			]);

	    $this->assertDatabaseHas('users', [
		    'name' => 'test-name',
		    'email' => 'test@gmail.com',
		    'description' => 'test-description'
	    ]);

	    $this->assertDatabaseHas('locations', [
		    'city' => 'test-city',
		    'state' => 'test-state',
		    'country' => 'test-country'
	    ]);
	}


	public function test_it_should_fail_due_to_different_passwords():void
	{
		$response = $this->post('api/user', [
				'name' => 'test-name',
				'email' => 'test@gmail.com',
				'password' => '123',
				'confirmPassword' => '1234',
				'description' => 'test-description',
				'city' => 'test-city',
				'state' => 'test-state',
				'country' => 'test-country'

		]);

		$response->assertStatus(401);
	}

	public function test_it_should_fail_due_to_email_already_being_registered():void
	{

		User::create([
			'name' => 'created-name',
			'email' => 'registered@email.com',
			'password' => '123'
		]);

		$this->assertDatabaseHas('users', [
			'name' => 'created-name',
			'email' => 'registered@email.com'
		]);

		$response = $this->post('api/user', [
				'name' => 'test-name',
				'email' => 'registered@email.com',
				'password' => '123',
				'confirmPassword' => '123',
				'description' => 'test-description',
				'city' => 'test-city',
				'state' => 'test-state',
				'country' => 'test-country'

		]);

		$response->assertStatus(401);

	}

	public function test_it_should_fail_due_to_not_passing_on_form_validation():void{
		//lack of obrigatory fields
		$response = $this->post('/api/auth/login', [
			'email' => 'wrong-email-format'	
		]);

		$response->assertStatus(422);

	}
}
