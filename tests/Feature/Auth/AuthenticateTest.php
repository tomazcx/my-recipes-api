<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Tymon\JWTAuth\JWTAuth;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthenticateTest extends TestCase{

	use RefreshDatabase;

	protected $user;

	public function setUp():void{
		parent::setUp();
		$this->user = User::create([
			'name' => 'test',
			'email' => 'test@gmail.com',
			'password' => Hash::make('test')
		]);
		
		$mockJwtAuth = $this->getMockBuilder(JWTAuth::class)->disableOriginalConstructor()->getMock();

		$mockJwtAuth->method('attempt')->willReturn('fake-token');

		$this->app->instance(JWTAuth::class, $mockJwtAuth);


	}

	public function test_it_should_authenticate_returning_a_jwt():void{
	
		$response = $this->post('/api/auth/login', [
			'email' => $this->user['email'],
			'password' => 'test'
		]);

		$this->assertArrayHasKey('token', $response->decodeResponseJson());
		$response->assertStatus(200);
	}

	public function test_it_should_fail_due_to_invalid_credentials():void{
		$response = $this->post('/api/auth/login', [
			'email' => 'wrong-email@gmail.com',
			'password' => 'wrong-password'
		]);

		$response->assertStatus(401);
	}

	public function test_it_should_fail_due_to_not_passing_on_form_validation():void{
		$response = $this->post('/api/auth/login', [
			'email' => 'wrong-email-format'	
		]);

		$response->assertStatus(422);

	}

}
