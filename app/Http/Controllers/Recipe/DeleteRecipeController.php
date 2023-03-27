<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use Src\Domain\Recipes\Services\AbstractDeleteRecipe;

class DeleteRecipeController extends Controller{

	protected AbstractDeleteRecipe $service;

	public function __construct(AbstractDeleteRecipe $service)
	{
		$this->service = $service;	
	}

	public function handle(int $id){
		$this->service->execute($id, auth('api')->user()->id);

		return response()->json([], 204);
	}

}
