<?php

namespace Src\Implementation\Comments\Repositories;

use App\Models\Comment as CommentModel;
use Src\Domain\Comments\Dto\AbstractCreateCommentDto;
use Src\Domain\Comments\Entities\AbstractComment;
use Src\Domain\Comments\Repositories\AbstractCommentRepository;
use Src\Implementation\Comments\Entities\Comment;

class CommentRepository extends AbstractCommentRepository{

	protected CommentModel $commentModel;

	public function __construct(CommentModel $commentModel)
	{
		$this->commentModel = $commentModel;	
	}

	public function exists(int $id): bool
	{
		$comment = $this->commentModel::find($id);

		return !!$comment;
	}

	public function show(int $id): AbstractComment
	{
		$comment = $this->commentModel::find($id);
	
		$commentObj = new Comment($comment);

		return $commentObj;
	}

	public function showRecipeComments(int $recipeId): array
	{
		$comments = $this->commentModel::where('recipe_id', $recipeId)->get();

		return $comments->toArray();
	}

	public function create(AbstractCreateCommentDto $createCommentDto, int $userId, int $recipeId): AbstractComment
	{
		$comment = $this->commentModel::create([
			'content' => $createCommentDto->content,
			'user_id' => $userId, 
			'recipe_id' => $recipeId
		]);	

		$commentObj = new Comment($comment);

		return $commentObj;
	}

	public function delete(int $id): void
	{
		$this->commentModel::destroy($id);
	}



}
