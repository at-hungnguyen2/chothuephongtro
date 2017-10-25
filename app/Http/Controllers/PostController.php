<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends Controller
{
    protected $post;
    /**
     * UserController constructor.
     *
     * @param Post $post dependence injection
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->post->with(
        		['user' => function($user) {
        			$user->select('id', 'name')->withCount('posts');
        		},
        		'district' => function($district) {
        			$district->select('id', 'district');
        		},
        		'subject' => function($subject) {
        			$subject->select('id', 'subject');
        		},
        		'postType' => function($postType) {
        			$postType->select('id', 'type');
        		}]
        	)->paginate(Post::ITEMS_PER_PAGE);
        // dd($posts);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Update specific post
     *
     * @param \Illuminate\Http\Request $request request value
     * @param Integer                  $id id of post
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
    	try {
    		$post = $this->post->findOrFail($id);
	    	if ($request->has('status')) {
	    		$post = $post->update(['status' => ($post->status ? Post::STATUS_NOTREADY : Post::STATUS_READY)]);
                $message = __('Update status successfully');
            } else if ($request->has('is_active')) {
                $post = $post->update(['is_active' => ($post->is_active ? Post::NOT_ACTIVE : Post::ACTIVE)]);
                $message = __('Update active successfully');
            }
    		if ($post) {
    			flash($message)->success()->important();
    		} else {
    			flash($message)->error()->important();
    		}
    	} catch (ModelNotFoundException $e) {
    		flash(__('Post has been not found'))->error()->important();
    	}

    	return redirect()->back();
    }

    /**
     * Delete specific post
     *
     * @param Integer $id id of post
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $post = $this->post->findOrFail($id)->delete();
            if ($post) {
                flash(__('Delete post succeed'))->success()->important();
            } else {
                flash(__('Delete post failed'))->error()->important();
            }
        } catch (ModelNotFoundException $e) {
            flash(__('Posst has been not found'))->error()->important();
        }

        return redirect()->back();
    }
}
