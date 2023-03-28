<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Src\Domain\Comments\Services\AbstractShowRecipeComments;

class ShowRecipeCommentsController extends Controller{

	protected AbstractShowRecipeComments $service;

	public function __construct(AbstractShowRecipeComments $service)
	{
		$this->service = $service;	
	}	

	public function handle(int $recipeId){
		$comments = $this->service->execute($recipeId);

		return response()->json($comments, 200);
	}

}
