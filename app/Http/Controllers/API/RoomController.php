<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;
use App\Comment;
use App\Room;
use App\Subject;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\DB;

class RoomController extends APIController
{
	protected $room;

	public function __construct(Room $room)
	{
		$this->room = $room;
	}

	/**
	 * Create new post from request
	 *
	 * @param Illuminate\Http\Request $request request from client
	 *
	 * @return Illuminate\Http\Response
	 */
	public function store(Request $request, $postId)
	{	
		if ($request->file('image')) {
			if ($request->file('image')->isValid()) {
				$destinationPath = public_path().env("ROOM_PATH");
				$fileName = env('POST_PATH').'/'.str_random(8).'.'.$request->file('image')->getClientOriginalExtension();
			}
		} else {
			$fileName = 'default_image.jpg';
		}
		$request->request->add(['post_id' => $postId]);
		$roomData = $request->all();
		$roomData['image'] = $fileName;
		$room = $this->room->create($roomData);
		if ($room) {
			if ($request->hasFile('image')) {
				$request->image->move($destinationPath, $fileName);
			}
			return response()->json(['room' => $room, 'success' => true], Response::HTTP_OK);
		}

		return response()->json(['success' => false], Response::HTTP_BAD_REQUEST);
	}

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $posts = Post::where('user_id', $request->user()->id)->get();
        $subjects = Subject::get();
        if ($posts && $subjects) {
        	return response()->json(['posts' => $posts, 'subjects' => $subjects, 'success => true'], Response::HTTP_OK);	
        }
        return response()->json(['success' => false], Response::HTTP_BAD_REQUEST);
    }

	/**
	 * Get specific post by id
	 *
	 * @param Integer $id id of post
	 *
	 * @return Illuminate\Http\Response
	 */
	public function show($id)
	{
		try {
			$room = $this->room->with([
        		'subject' => function($subject) {
        			$subject->select('id', 'subject');
        		},
        		'post' => function($post) {
        			$post->select('id', 'title');
        		}])->findOrFail($id);
			return response()->json(['data' => $room, 'success' => true], Response::HTTP_OK);
		} catch(ModelNotFoundException $e) {
			return response()->json(['message' => __('This post is not found')], Response::HTTP_NOT_FOUND);
		}
	}

	/**
	 * Update specific room from request
	 *
	 * @param Integer                 $id id of room
	 * @param Illuminate\Http\Request $request request from client
	 *
	 * @return Illuminate\Http\Response
	 */
	public function update($id, Request $request)
	{
		try {
			$room = $this->room->findOrFail($id)->update($request->all());
			if ($room) {
				$message = __('Update this room success');
				$response = Response::HTTP_OK;
			} else {
				$message = __('Has error during update this room');
				$response = Response::HTTP_BAD_REQUEST;
			}
		} catch (ModelNotFoundException $e) {
			$message = __('This room has been not found');
			$response = Response::HTTP_NOT_FOUND;
		}

		return response()->json(['message' => $message], $response);
	}

	/**
	 * Delete specific room
	 *
	 * @param Integer $id id of room
	 *
	 * @return Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try {
			$room = $this->room->findOrFail($id)->delete();
			if ($room) {
				$message = __('Delete this room succeed');
				$response = Response::HTTP_OK;
			} else {
				$message = __('Has error during delete this room');
				$response = Response::HTTP_BAD_REQUEST;
			}
		} catch (ModelNotFoundException $e) {
			$message = __('This room has been not found');
			$response = Response::HTTP_NOT_FOUND;
		}

		return response()->json(['message' => $message], $response);
	}
}