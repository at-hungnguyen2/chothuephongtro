<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFountException;
use App\Comment;

class CommentController extends APIController
{
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
	public function store(Request $request, $postId)
	{
		$request->request->add(['user_id' => $request->user()->id, 'post_id' => $postId]);
		$comment = $this->comment->create($request->all());
		if ($comment) {
			return response()->json(['data' => $comment, 'success' => true], Response::HTTP_OK);
		}
		return response()->json(['message' => __('Create fail')], Response::HTTP_BAD_REQUEST);
	}

	/**
	 * Update specific comment by id
	 *
	 * @param Integer                 $id
	 * @param Illuminate\Http\Request $request request from client
	 *
	 * @return Illuminate\Http\Response
	 */
	public function update($id, Request $request)
	{
		try {
			$comment = $this->comment->findOrFail($id);
			if ($request->user()->id == $comment->user_id) {
				$comment->update($request->all());
				if ($comment) {
					$message = __('Update succeed');
					$response = Response::HTTP_OK;
				} else {
					$message = __('Update failed');
					$response = Response::HTTP_BAD_REQUEST;	
				}
			} else {
				$message = __('You can not edit comment of another one');
				$response = Response::HTTP_BAD_REQUEST;
			}
		} catch (ModelNotFountException $e) {
			$message = __('This comment has been not found');
			$response = Response::HTTP_NOT_FOUND;
		}

		return response()->json(['message' => $message], $response);
	}

	/**
	 * Delete specific comment
	 *
	 * @param Integer $id id of comment
	 *
	 * @return Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try {
			$comment = $this->comment->findOrFail($id)->delete();
			if ($comment) {
				$message = __('Delete this comment succeed');
				$response = Response::HTTP_OK;
			} else {
				$message = __('Has error during delete this comment');
				$response = Response::HTTP_BAD_REQUEST;
			}
		} catch (ModelNotFoundException $e) {
			$message = __('This comment has been not found');
			$response = Response::HTTP_NOT_FOUND;
		}

		return response()->json(['message' => $message], $response);
	}
}