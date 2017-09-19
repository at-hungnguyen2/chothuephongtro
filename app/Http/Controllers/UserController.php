<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{
    protected $user;
    /**
     * UserController constructor.
     *
     * @param User $user dependence injection
     */
    public function __construct(UserRepositoryInterface $user)
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
        $users = $this->user->getAllUserNotAdmin();
        return view('user.index')->with('users', $users);
    }
}
