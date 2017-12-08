<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Post;
use Illuminate\Support\Facades\File;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserPasswordChanged;
use Unicodeveloper\EmailValidator\EmailValidator;
use Illuminate\Support\Facades\Hash;

class UserController extends APIController
{
    use ApiResponser;

    protected $user;
    protected $client;
    protected $emailValidator;

    public function __construct(User $user, EmailValidator $emailValidator)
    {
        $this->user = $user;
        $this->client = DB::table('oauth_clients')->where('id', 2)->first();
        $this->emailValidator = $emailValidator;
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
        $rules = [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
        // dd($request->all());
        $this->validate($request, $rules);

        if ($this->emailValidator->verify($request->email)->isValid()[0]) {
            $user = $this->user->create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => bcrypt($request->password)
            ]);
            return response()->json(['data' => $user, 'success' => true], Response::HTTP_OK);
        }
        return $this->errorResponse('This email is not existed, please make sure you fill in existed email!', 404);
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
        $user = $this->user->findOrFail($request->user()->id);

        return response()->json([
                'user' => $user,
                'success' => true
            ], Response::HTTP_OK);
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
            $userId = $request->user()->id;
            $request->request->add(['id' => $userId]);
            if ($request->hasFile('image')) {
                if ($request->file('image')->isValid()) {
                    $destinationPath = public_path().env('USER_PATH');
                    $fileName = env('USER_PATH').'/'.str_random(8).'.'.$request->file('image')->getClientOriginalExtension();
                }
            } else {
                $fileName = 'default_image.jpg';
            }
            
            $oldFileName = $request->user()->image;
            
            $dataUser = $request->all();

            $user = $this->user->findOrFail($userId);
            if ($request->has('old_password') && $request->old_password != null) {
                $oldpass = $request->old_password;
                if (!Hash::check($oldpass, $user->password)) {
                    return response()->json(['message' => __('Old password is wrong')], Response::HTTP_BAD_REQUEST);
                } else {
                    $dataUser['password'] = Hash::make($dataUser['password']);
                }
            }

		    $dataUser['image'] = $fileName;
            $user = $user->update(array_filter($dataUser));
            if ($user) {
                if ($request->hasFile('image')) {
                    $request->image->move($destinationPath, $fileName);
                }
                if ($oldFileName) {
                    File::delete(public_path().env('USER_PATH').'/'.$oldFileName);
                }
                $message = __('Update success');
                $response = Response::HTTP_OK;
            } else {
                $message = __('Has error during update your profile');
                $response = Response::HTTP_BAD_REQUEST;
            }
        } else {
            return response()->json(['message' => __('Cannot update role')], Response::HTTP_BAD_REQUEST);
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

    public function resetPassword($token)
    {
        $user = User::where('reset_password_token', $token)->firstOrFail();
        $newPassword = str_random(6);

        $user->reset_password_token = null;
        $user->password = bcrypt($newPassword);
        $user->save();

        return view('email.resetsuccess')->with(['user' => $user, 'newPassword' => $newPassword]);
    }

    public function offerResetPassword($email)
    {
        $user = User::where('email', $email)->firstOrFail();
        if ($user->reset_password_token != null) {
            return $this->errorResponse('The reset password email has been send before, please check your email again!', 409);
        }

        $user->reset_password_token = User::generateResetPasswordCode();
        $user->save();

        Mail::to($user)->send(new UserPasswordChanged($user));

        return $this->showMessage("The reset password email has been send");
    }
}
?>