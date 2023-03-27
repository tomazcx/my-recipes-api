<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recipe\UpdateRecipeRequest;
use Src\Domain\Recipes\Services\AbstractUpdateRecipe;
use Src\Implementation\Recipes\Dto\UpdateRecipeDto;

class UpdateRecipeController extends Controller{

	protected AbstractUpdateRecipe $service;

	public function __construct(AbstractUpdateRecipe $service)
	{
		$this->service = $service;	
	}

	public function handle(UpdateRecipeRequest $request, int $id){
		$dto = new UpdateRecipeDto($request->validated());

		$recipe = $this->service->execute($dto, $id, auth('api')->user()->id);

		return response()->json($recipe, 200);
	}

}
