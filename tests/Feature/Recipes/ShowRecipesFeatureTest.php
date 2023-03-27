<?php

namespace Tests\Feature\Recipes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowRecipesFeatureTest extends TestCase{

	use RefreshDatabase;

	public function test_it_should_show_all_recipes():void
	{
		$response = $this->get('/api/recipe');
		$response->assertStatus(200);
	}

	public function test_it_should_show_all_recipes_that_matches_a_certain_name():void
	{
		$response = $this->get('/api/recipe?name=test');
		$response->assertStatus(200);
	}

	public function test_it_should_show_all_recipes_that_belongs_to_a_category():void
	{
		$response = $this->get('/api/recipe?category=1');
		$response->assertStatus(200);
	}

	public function test_it_should_show_all_recipes_that_matches_a_certain_name_and_belongs_to_a_category():void
	{
		$response = $this->get('/api/recipe?name=test&category=1');
		$response->assertStatus(200);
	}

		
}
