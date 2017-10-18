<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFountException;
use App\Comment;
use App\Traits\ApiResponser;

class CommentController extends APIController
{
	use ApiResponser;

	protected $comment;

	/**
     * CommentController constructor.
     *
     * @param Comment $comment dependence injection
     */
	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}

	/**
	 * Create new comment from request
	 *
	 * @param Illuminate\Http\Request $request request from client
	 *
	 * @return Illuminate\Http\Response
	 */
	public function store(StoreCommentRequest $request, $postId)
	{
		$request->request->add(['user_id' => $request->user()->id, 'post_id' => $postId]);
		$comment = $this->comment->create($request->all());

		if ($comment) {
			return $this->showOne($comment, Response::HTTP_OK);
		}
		return $this->errorResponse('Create fail', Response::HTTP_BAD_REQUEST);
	}

	/**
	 * Update specific comment by id
	 *
	 * @param Integer                 $id
	 * @param Illuminate\Http\Request $request request from client
	 *
	 * @return Illuminate\Http\Response
	 */
	public function update(Comment $comment, UpdateCommentRequest $request)
	{
		$comment = $comment->update($request->all());

		if ($comment) {
			return $this->successResponse('Update success', Response::HTTP_OK);
		}

		return $this->errorResponse('Update failed', Response::HTTP_BAD_REQUEST);
	}

	/**
	 * Delete specific comment
	 *
	 * @param Integer $id id of comment
	 *
	 * @return Illuminate\Http\Response
	 */
	public function destroy(Comment $comment, Request $request)
	{
		$comment = $comment->delete();

		if ($comment) {
			return $this->successResponse('Delete this comment succeed', Response::HTTP_OK);
		}

		return $this->errorResponse('Has error during delete this comment', Response::HTTP_BAD_REQUEST);
	}
}