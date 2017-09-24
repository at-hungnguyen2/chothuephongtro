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
        		}]
        	)->paginate(Post::ITEMS_PER_PAGE);
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
    	$request = $request->except('_method', '_token');
    	try {
    		$post = $this->post->findOrFail($id);
	    	if (!$request) {
	    		$post = $post->update(['status' => ($post->status ? Post::STATUS_NOTREADY : Post::STATUS_READY)]);
	    		if ($post) {
	    			flash(__('Update status Successfully!'))->success()->important();
	    		} else {
	    			flash(__('Update status failed!'))->error()->important();
	    		}
	    	}
    	} catch (ModelNotFoundException $e) {
    		flash(__('Post has been not found'))->error()->important();
    	}

    	return redirect()->route('posts.index');
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
