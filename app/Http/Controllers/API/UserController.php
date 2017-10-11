<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Post;

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
        $posts = Post::where('user_id', $user->id)->with('rooms')->get();
        if (!$user) {
            return response()->json(['success' => false, 'message' => __('Error during get current user')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['user' => $user, 'post' => $posts, 'success' => true], Response::HTTP_OK);
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
        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password)
        ]);
        return response()->json(['data' => $user, 'success' => true], Response::HTTP_OK);
    }

    /**
     * Show to edit specific user
     *
     * @param Illuminate\Http\Request
     *
     * @return Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {
            $user = $this->user->findOrFail($request->user()->id);

            return response()->json([
                    'user' => $user,
                    'success' => true
                ], Response::HTTP_OK);
        } catch(ModelNotFoundException $e) {
            return response()->json(['message' => __('This user is not found')], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update specific post from request
     *
     * @param Illuminate\Http\Request $request request from client
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->has('is_admin')) {
            try {
                $userId = $request->user()->id;
                $request->request->add(['id' => $userId]);
                $user = $this->user->findOrFail($userId)->updateNotNull($request->all());
                if ($user) {
                    $message = __('Update success');
                    $response = Response::HTTP_OK;
                } else {
                    $message = __('Has error during update your profile');
                    $response = Response::HTTP_BAD_REQUEST;
                }
            } catch (ModelNotFoundException $e) {
                $message = __('Did you login?');
                $response = Response::HTTP_NOT_FOUND;
            }
        } else {
            return response()->json(['message' => __('Cannot update status')], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => $message], $response);
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