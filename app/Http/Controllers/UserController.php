<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $user;
    /**
     * UserController constructor.
     *
     * @param User $user dependence injection
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate(User::ITEMS_PER_PAGE);
        return view('users.index')->with('users', $users);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id id of user's detail
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userToShow = $this->user->findOrFail($id);
        $posts = Post::where('user_id', $id)->paginate(Post::ITEMS_PER_PAGE);
        return view('users.show', ['user' => $userToShow, 'posts' => $posts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id id user update
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request request user update
     * @param int               $id      id user update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $requestInput = $request->except('_method', '_token');
        if ($request->hasFile('image')) {
            $requestInput['image'] = $this->getImageFileName($request);
        }

        $userToUpdate = $this->user->findOrFail($id);
        if ($userToUpdate->update(array_filter($requestInput))) {
            if ($request->hasFile('image')) {
                $destinationPath = public_path().env('USER_PATH');
                $fileName = $requestInput['image'];
                $request->image->move($destinationPath, $fileName);
            }
            flash(__('Update Successfully'))->success()->important();
            return redirect()->route('users.edit', $id);
        } else {
            flash(__('Update Error'))->error()->important();
            return redirect()->route('users.edit', $id)->withInput();
        }
    }

    /**
     * Get filename from request
     *
     * @param Request $request the request need to get file name
     *
     * @return string
     */
    public function getImageFileName(Request $request)
    {
        if ($request->hasFile('image')) {
            $fileName = env('USER_PATH').'/'.str_random(8).'.'.$request->file('image')->getClientOriginalExtension();;
        } else {
            $fileName = 'default.jpg';
        }
        return $fileName;
    }

    /**
     * Destroy user
     *
     * @param Integer $id id of user to destroy
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (Auth::user()->id == $id) {
            flash(__('Cannot delete current user!'))->error()->important();
        } else {
            try {
                $userToDel = $this->user->findOrFail($id);
                $userToDel->delete();
                flash(__('Delete Successfully!'))->success()->important();
            } catch (\Exception $ex) {
                flash(__('Delete Error!'))->error()->important();
            }
        }
        return redirect()->route('users.index');
    }
}
