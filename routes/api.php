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
	Route::get('/users', 'API\UserController@show');
	Route::post('/posts', 'API\PostController@store');
	Route::put('/posts/{id}', 'API\PostController@update');
	Route::delete('/posts/{id}', 'API\PostController@destroy');
	Route::post('/comments', 'API\CommentController@store');
	Route::put('/comments/{id}', 'API\CommentController@update');
	Route::post('/posts/{post_id}/rooms', 'API\RoomController@store');
});

Route::POST('/users/register', 'API\UserController@store');

Route::post('/users/login', 'API\UserController@login');

Route::get('/posts/{id}', 'API\PostController@show');

Route::get('/posts', 'API\PostController@index');

Route::get('/rooms/{id}', 'API\RoomController@show');
