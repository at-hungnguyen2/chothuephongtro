<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;
use App\Comment;
use App\Room;
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
		if ($request->file('image')->isValid()) {
			$destinationPath = public_path().'/uploads/posts';
			$fileName = str_random(8).'.'.$request->file('image')->getClientOriginalExtension();
		} else {
			$fileName = 'default_image.jgp';
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
        		'cost' => function($cost) {
        			$cost->select('id', 'cost');
        		},
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
}