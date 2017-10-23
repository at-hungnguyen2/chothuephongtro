<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;

class RoomController extends Controller
{
    protected $room;
    /**
     * RoomController constructor.
     *
     * @param Room $room dependence injection
     */
    public function __construct(Room $room)
    {
        $this->room = $room;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $rooms = $this->room->with(
        		[
        		'subject' => function($subject) {
        			$subject->select('id', 'subject');
        		},
        		'post' => function($post) {
        			$post->select('id', 'title');
        		}]
        	)->where('post_id', $id)
        	->paginate(Room::ITEMS_PER_PAGE);
        return view('rooms.index')->with('rooms', $rooms);
    }

    public function update($id, Request $request)
    {
    	try {
    		$room = $this->room->findOrFail($id);
    		$postId = $room->post_id;
	    	if ($request->has('status')) {
	    		$room = $room->update(['status' => ($room->status ? Room::STATUS_NOTREADY : Room::STATUS_READY)]);
                $message = __('Update status successfully');
            }

    		if ($room) {
    			flash($message)->success()->important();
    		} else {
    			flash($message)->error()->important();
    		}
    	} catch (ModelNotFoundException $e) {
    		flash(__('Room has been not found'))->error()->important();
    	}

    	return redirect()->route('rooms.index', $postId);
    }
}
