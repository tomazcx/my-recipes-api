<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CreateCommentRequest;
use Src\Domain\Comments\Services\AbstractCreateComment;
use Src\Implementation\Comments\Dto\CreateCommentDto;

class CreateCommentController extends Controller{

	protected AbstractCreateComment $service;

	public function __construct(AbstractCreateComment $service)
	{
		$this->service = $service;	
	}	

	public function handle(CreateCommentRequest $request, int $recipeId){
		$dto = new CreateCommentDto($request->validated());

		$comment = $this->service->execute($dto, auth('api')->user()->id, $recipeId);

		return response()->json($comment, 201);
	}

}
