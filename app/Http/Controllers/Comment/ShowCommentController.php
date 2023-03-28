<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Src\Domain\Comments\Services\AbstractShowComment;

class ShowCommentController extends Controller{

	protected AbstractShowComment $service;

	public function __construct(AbstractShowComment $service)
	{
		$this->service = $service;	
	}

	public function handle(int $id){
		$comment = $this->service->execute($id);

		return response()->json($comment, 200);
	}

}
