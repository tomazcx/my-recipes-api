<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Src\Domain\Comments\Services\AbstractDeleteComment;

class DeleteCommentController extends Controller{

	protected AbstractDeleteComment $service;

	public function __construct(AbstractDeleteComment $service)
	{
		$this->service = $service;	
	}

	public function handle(int $id){
		$this->service->execute($id, auth('api')->user()->id);

		return response()->json([], 204);
	}

}
