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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

// Route for Admin
Route::get('/admin', function(){
    return view('admin.index');
});

// Security for admin
Route::group(['middleware'=>'admin'], function(){
    // Creating Route for Admin folder managing User
    Route::resource('/admin/users', 'AdminUsersController');

    // Route for Admin to manage Post
    Route::resource('/admin/posts', 'AdminPostsController');

    Route::resource('/admin/categories', 'AdminCategoriesController');

    Route::resource('/admin/media', 'AdminMediasController');

    //Custom Route - can also create by using function: refer in earlier videos
    //Route::get('admin/media/upload', ['as'=>'admin.media.upload', 'uses'=>'AdminMediasController@store']);

    Route::resource('/admin/comments', 'PostCommentsController');

    Route::resource('/admin/comments/replies', 'CommentRepliesController');
});
