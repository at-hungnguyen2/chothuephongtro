<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function() {
	Route::prefix('posts')->group(function() {
		Route::post('/{post_id}/comments', 'API\CommentController@store');
		Route::post('/{post_id}/rooms', 'API\RoomController@store');
		Route::post('/{post_id}/room', 'API\RoomController@storeOne');
	});
	Route::get('/users', 'API\UserController@show');
	Route::get('/users/edit', 'API\UserController@edit');
	Route::post('/users/update', 'API\UserController@update');
	Route::resource('comments', 'API\CommentController', ['only' => ['update', 'destroy']]);
	Route::resource('rooms', 'API\RoomController', ['only' => ['create', 'edit', 'update', 'destroy']]);
	Route::resource('posts', 'API\PostController', ['only' => ['create', 'edit', 'store', 'update', 'destroy']]);
});

Route::POST('/users/register', 'API\UserController@store');

Route::post('/users/login', 'API\UserController@login');

Route::get('/posts/{id}', 'API\PostController@show');

Route::get('/posts', 'API\PostController@index');

Route::get('/rooms/{id}', 'API\RoomController@show');
