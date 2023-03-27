<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use Src\Domain\Recipes\Services\AbstractShowRecipe;

class ShowRecipeController extends Controller{

	protected AbstractShowRecipe $service;

	public function __construct(AbstractShowRecipe $service)
	{
		$this->service = $service;	
	}

	public function handle(int $id)
	{
		$recipe = $this->service->execute($id);

		return response()->json($recipe, 200);
	}

}
