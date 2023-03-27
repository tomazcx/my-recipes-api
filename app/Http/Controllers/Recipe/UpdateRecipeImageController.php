<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recipe\UpdateRecipeImageRequest;
use Src\Domain\Recipes\Services\AbstractUpdateRecipeImage;

class UpdateRecipeImageController extends Controller{

	protected AbstractUpdateRecipeImage $service;

	public function __construct(AbstractUpdateRecipeImage $service)
	{
		$this->service = $service;	
	}	

	public function handle(UpdateRecipeImageRequest $request, int $id)
	{
		$data = $request->validated();
		$image = $data['image']->store('recipes');
	
		$recipe = $this->service->execute($image, $id, auth('api')->user()->id);

		return response()->json($recipe, 200);
	}
}
