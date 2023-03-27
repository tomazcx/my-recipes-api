<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use Src\Domain\Recipes\Services\AbstractShowRecipes;
use Illuminate\Http\Request;

class ShowRecipesController extends Controller{

	protected AbstractShowRecipes $service;

	public function __construct(AbstractShowRecipes $service)
	{
		$this->service = $service;	
	}

	public function handle(Request $request){
		$recipes = $this->service->execute($request->query('name'), $request->query('category'));

		return response()->json($recipes, 200);
	}

}
