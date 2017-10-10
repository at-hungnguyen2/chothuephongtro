<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;
use App\Comment;
use App\Room;
use App\District;
use App\Cost;
use App\PostType;
use App\Subject;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\DB;
use App\Traits\Permission;

class PostController extends APIController
{
	use Permission;

	protected $post;
	protected $comment;
	protected $room;

	public function __construct(Post $post, Comment $comment, Room $room)
	{
		$this->post = $post;
		$this->comment = $comment;
		$this->room = $room;
	}

	/**
	 * Get all post
	 *
	 * @return Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$posts = $this->post->filter($request->all())->with(
        		['user' => function($user) {
        			$user->select('id', 'name');
        		},
        		'district' => function($district) {
        			$district->select('id', 'district');
        		},
        		'cost' => function($cost) {
        			$cost->select('id', 'cost');
        		},
        		'subject' => function($subject) {
        			$subject->select('id', 'subject');
        		},
        		'postType' => function($postType) {
        			$postType->select('id', 'type');
        		}])
				->where('is_active', Post::ACTIVE)->where('status', Post::STATUS_READY)
				->paginate(POST::ITEMS_PER_PAGE);
		$subjects = Subject::select('id', 'subject')->get();
		$postTypes = PostType::select('id', 'type')->get();
		$costs = Cost::select('id', 'cost')->get();
		return response()->json([
			'data' => $posts,
			'subjects' => $subjects,
			'postTypes' => $postTypes,
			'costs' => $costs,
			'success' => true
		], Response::HTTP_OK);
	}

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $districts = District::select('id', 'district')->get();
        $subjects = Subject::select('id', 'subject')->get();
        $costs = Cost::select('id', 'cost')->get();
        $postTypes = PostType::select('id', 'type')->get();
        if ($districts && $subjects && $costs && $postTypes) {
        	return response()->json([
        		'districts' => $districts,
        		'subjects' => $subjects,
        		'costs' => $costs,
        		'postTypes' => $postTypes,
        		'success => true'], Response::HTTP_OK);
        }
        return response()->json(['success' => false], Response::HTTP_BAD_REQUEST);
    }

	/**
	 * Create new post from request
	 *
	 * @param Illuminate\Http\Request $request request from client
	 *
	 * @return Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if ($request->hasFile('image')) {
			if ($request->file('image')->isValid()) {
				$destinationPath = public_path().env('POST_PATH');
				$fileName = env('POST_PATH').'/'.str_random(8).'.'.$request->file('image')->getClientOriginalExtension();
			}
		} else {
			$fileName = 'default_image.jpg';
		}
		
		$arrPost = $request->all();
		$arrPost['image'] = $fileName;
		$arrPost['user_id'] = $request->user()->id;
		$post = $this->post->create($arrPost);

		if ($post) {
			if ($request->hasFile('image')) {
				$request->image->move($destinationPath, $fileName);
			}
			return response()->json(['data' => $post, 'success' => true], Response::HTTP_OK);
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
			$post = $this->post->with(
        		['user' => function($user) {
        			$user->select('id', 'name', 'email', 'phone_number');
        		},
        		'district' => function($district) {
        			$district->select('id', 'district');
        		},
        		'cost' => function($cost) {
        			$cost->select('id', 'cost');
        		},
        		'subject' => function($subject) {
        			$subject->select('id', 'subject');
        		},
        		'postType' => function($postType) {
        			$postType->select('id', 'type');
        		}])->findOrFail($id);
			$rooms = $this->room->where('post_id', $id)->get();
			$comments = $this->comment->getPostComments($id);
			return response()->json([
					'data' => $post,
					'rooms' => $rooms,
					'comments' => $comments,
					'success' => true
				], Response::HTTP_OK);
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
	public function edit(Request $request, $id)
	{
		try {
			$postOld = $this->post->with(
        		['user' => function($user) {
        			$user->select('id', 'name', 'email', 'phone_number');
        		},
        		'district' => function($district) {
        			$district->select('id', 'district');
        		},
        		'cost' => function($cost) {
        			$cost->select('id', 'cost');
        		},
        		'subject' => function($subject) {
        			$subject->select('id', 'subject');
        		},
        		'postType' => function($postType) {
        			$postType->select('id', 'type');
        		}])->findOrFail($id);
			if ($postOld->user_id != $request->user()->id) {
				return response()->json(['message' => __('You are not permissoned to edit this post')], Response::HTTP_BAD_REQUEST);
			}
			$rooms = $this->room->where('post_id', $id)->get();
			$districts = District::select('id', 'district')->get();
			$costs = Cost::select('id', 'cost')->get();
			$subjects = Subject::select('id', 'subject')->get();
			$postTypes = PostType::select('id', 'type')->get();
			return response()->json([
					'oldData' => $postOld,
					'rooms' => $rooms,
					'districts' => $districts,
					'costs' => $costs,
					'subjects' => $subjects,
					'postTypes' => $postTypes,
					'success' => true
				], Response::HTTP_OK);
		} catch(ModelNotFoundException $e) {
			return response()->json(['message' => __('This post is not found')], Response::HTTP_NOT_FOUND);
		}
	}

	/**
	 * Update specific post from request
	 *
	 * @param Integer                 $id id of post
	 * @param Illuminate\Http\Request $request request from client
	 *
	 * @return Illuminate\Http\Response
	 */
	public function update($id, Request $request)
	{
		$post = $this->post->findOrFail($id);
		if (!$request->has('is_active') && $this->permission($request->user()->id, $post)) {
			try {
				$request->request->add(['id' => $id]);
				$post = $post->updateNotNull($request->all());
				if ($post) {
					$message = __('Update this post success');
					$response = Response::HTTP_OK;
				} else {
					$message = __('Has error during update this post');
					$response = Response::HTTP_BAD_REQUEST;
				}
			} catch (ModelNotFoundException $e) {
				$message = __('This post has been not found');
				$response = Response::HTTP_NOT_FOUND;
			}
		} else {
			return response()->json(['message' => __('Has error during process')], Response::HTTP_BAD_REQUEST);
		}

		return response()->json(['message' => $message], $response);
	}

	/**
	 * Delete specific post
	 *
	 * @param Integer $id id of post
	 *
	 * @return Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try {
			$post = $this->post->findOrFail($id)->delete();
			if ($post) {
				$message = __('Delete this post succeed');
				$response = Response::HTTP_OK;
			} else {
				$message = __('Has error during delete this post');
				$response = Response::HTTP_BAD_REQUEST;
			}
		} catch (ModelNotFoundException $e) {
			$message = __('This post has been not found');
			$response = Response::HTTP_NOT_FOUND;
		}

		return response()->json(['message' => $message], $response);
	}
}