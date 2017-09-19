<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class UserController extends APIController
{
    protected $user;
    protected $client;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->client = DB::table('oauth_clients')->where('id', 2)->first();    
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request request get user information
     *
     * @return mixed
     */
    public function show(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => __('Error during get current user')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['data' => $user,'success' => true], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRegisterRequest $request request store data user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->user->create($request->all());
        return response()->json(['data' => $user, 'success' => true], Response::HTTP_OK);
    }

    /**
     * Login system and get token for client.
     *
     * @param \Illuminate\Http\Request $request request create
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*'
        ];
        $request->request->add($params);
        $proxy = Request::create('oauth/token', 'POST');
        return Route::dispatch($proxy);
    }
}
?>