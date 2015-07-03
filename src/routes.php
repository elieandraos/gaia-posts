<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::model('post-types', 'App\Models\PostType');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function()
{
   
	//Post Type Routes
   Route::get('/post-types', ['as' => 'admin.post-types.list', 'uses' => 'Gaia\Posts\PostTypeController@index']);
   Route::post('/post-types/store', ['as' => 'admin.post-types.store', 'uses' => 'Gaia\Posts\PostTypeController@store']);   
   Route::get('/post-types/{id}/edit', ['as' => 'admin.post-types.edit', 'uses' => 'Gaia\Posts\PostTypeController@edit']);
   Route::post('/post-types/{id}/update', ['as' => 'admin.post-types.update', 'uses' => 'Gaia\Posts\PostTypeController@update']);
   Route::post('/post-types/{id}/delete', ['as' => 'admin.post-types.delete', 'uses' => 'Gaia\Posts\PostTypeController@destroy']);

   //Post Routes
   Route::get('/post-types/{posttypeid}/posts/', ['as' => 'admin.posts.list', 'uses' => 'Gaia\Posts\PostController@index']);
   Route::get('/post-types/{posttypeid}/posts/create', ['as' => 'admin.posts.create', 'uses' => 'Gaia\Posts\PostController@create']);
   Route::post('/post-types/{posttypeid}/posts/store', ['as' => 'admin.posts.store', 'uses' => 'Gaia\Posts\PostController@store']);
});