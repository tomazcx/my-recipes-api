<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recipe\CreateRecipeRequest;
use Src\Domain\Recipes\Services\AbstractCreateRecipe;
use Src\Implementation\Recipes\Dto\CreateRecipeDto;

class CreateRecipeController extends Controller{

	protected AbstractCreateRecipe $service;

	public function __construct(AbstractCreateRecipe $service)
	{
		$this->service = $service;	
	}

	public function handle(CreateRecipeRequest $request){

		$data = $request->validated();

		$data['image'] = $data['image']->store('recipes');

		$createRecipeDto = new CreateRecipeDto($data);

		$recipe = $this->service->execute($createRecipeDto, auth('api')->user()->id);

		return response()->json($recipe, 201);
	}

}
