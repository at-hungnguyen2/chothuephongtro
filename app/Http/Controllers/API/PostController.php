<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends APIController
{
	protected $post;

	public function __construct(Post $post)
	{
		$this->post = $post;
	}

	public function index()
	{
		$posts = $this->post->paginate(POST::ITEMS_PER_PAGE);
		return response()->json(['data' => $posts, 'success' => true], Response::HTTP_OK);
	}

	public function store(Request $request)
	{
		$request->request->add(['user_id' => $request->user()->id]);
		$post = $this->post->create($request->all());
		if ($post) {
			return response()->json(['data' => $post, 'success' => true], Response::HTTP_OK);
		}
		return response()->json(['success' => false], Response::HTTP_BAD_REQUEST);
	}

	public function show($id)
	{
		try {
			$post = $this->post->findOrFail($id);
			return response()->json(['data' => $post, 'success' => true], Response::HTTP_OK);
		} catch(ModelNotFoundException $e) {
			return response()->json(['message' => __('This post is not found')], Response::HTTP_NOT_FOUND);
		}
	}
}