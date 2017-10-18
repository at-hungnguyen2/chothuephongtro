<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreRoomRequest;
use App\Post;
use App\Comment;
use App\Room;
use App\Subject;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\DB;
use App\Traits\Permission;

class RoomController extends APIController
{
	use Permission;

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
		DB::beginTransaction();
		$fileNames = array();
		$roomData = array();
		$amounts = $request->amount;
		$subjects = $request->subject_id;
		$costs = $request->cost;
		$counts = count($amounts);
		if ($request->hasFile('image')) {
			$images = $request->images;
			$i = 0;
			foreach ($images as $image) {
				if ($image->isValid()) {
					$destinationPath = public_path().env("ROOM_PATH");
					$fileNames[$i] = env('POST_PATH').'/'.str_random(8).'.'.$request->file('image')->getClientOriginalExtension();
					$image->move($destinationPath, $fileNames[$i]);
				} else {
					$fileNames[$i] = 'default_image.jpg';
				}
				$i++;
			}
		} else {
			for ($i = 0; $i < $counts; $i++) {
				$fileNames[$i] = 'default_image.jpg';
			}
		}
		for ($i = 0; $i < $counts; $i++) {
			$roomData['subject_id'] = $subjects[$i];
			$roomData['cost'] = $costs[$i];
			$roomData['amount'] = $amounts[$i];
			$roomData['post_id'] = $postId;
			$roomData['image'] = $fileNames[$i];
			$room = $this->room->create($roomData);
			if (!$room) {
				DB::rollback();
				return response()->json(['success' => false], Response::HTTP_BAD_REQUEST);
			}
		}
		DB::commit();
		return response()->json(['room' => $room, 'success' => true], Response::HTTP_OK);
	}

	public function storeOne(StoreRoomRequest $request, $postId)
	{
		if ($request->hasFile('image') && $request->image->isValid()) {
			$image = $request->image;
			$destinationPath = public_path().env("ROOM_PATH");
			$fileName = env('POST_PATH')
						.'/'
						.str_random(8)
						.'.'
						.$request->file('image')
						->getClientOriginalExtension();
			$image->move($destinationPath, $fileName);
		} else {
			$fileName = 'default_image.jpg';
		}
		$roomData = array();
		$roomData['amount'] = $request->amount;
		$roomData['subject_id'] = $request->subject_id;
		$roomData['cost'] = $request->cost;
		$roomData['post_id'] = $postId;
		$roomData['image'] = $fileName;
		$room = $this->room->create($roomData);
		if (!$room) {
			return response()->json(['success' => false], Response::HTTP_BAD_REQUEST);
		}
		return response()->json(['room' => $room, 'success' => true], Response::HTTP_OK);
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
	 * Show to edit specific post
	 *
	 * @param Integer $id id of post
	 *
	 * @return Illuminate\Http\Response
	 */
	public function edit($id, Request $request)
	{
		try {
			$room = $this->room->with([
        		'subject' => function($subject) {
        			$subject->select('id', 'subject');
        		},
        		'post' => function($post) {
        			$post->select('id', 'title', 'user_id');
        		}])->findOrFail($id);
			if ($room->post->user_id != $request->user()->id) {
				return response()->json(['message' => __('You are not permissoned to edit this room')], Response::HTTP_BAD_REQUEST);
			}
			$posts = Post::select('id', 'title')->where('user_id', $request->user()->id)->get();
			$subjects = Subject::select('id', 'subject')->get();
			return response()->json(['oldRoom' => $room, 'posts' => $posts, 'subjects' => $subjects, 'success' => true], Response::HTTP_OK);
		} catch (ModelNotFoundException $e) {
			$message = __('This room has been not found');
			$response = Response::HTTP_NOT_FOUND;
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
			$room = $this->room->with('post')->findOrFail($id);
			if ($this->permission($request->user()->id, $room->post)) {
				$request->request->add(['id' => $id]);
				$room = $room->updateNotNull($request->all());
				if ($room) {
					$message = __('Update this room success');
					$response = Response::HTTP_OK;
				} else {
					$message = __('Has error during update this room');
					$response = Response::HTTP_BAD_REQUEST;
				}	
			} else {
				$message = __('Dont have permission to update this room');
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