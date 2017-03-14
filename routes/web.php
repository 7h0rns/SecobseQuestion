<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Route::get('home', 'HomeController@index');

Auth::routes();

Route::get('email/verify/{token}',['as' => 'email.verify', 'uses' => 'EmailController@verify']);

Route::resource('home', 'HomeController', ['only' => [
	'index','store'
]]);

Route::resource('', 'MainPageController', ['only' => [
	'index'
]]);

Route::resource('questions', 'QuestionController');
Route::get('/search', 'QuestionController@search')->name('search');
Route::resource('posts', 'PostController', ['names' =>[
    'create' => 'post.create',
    'show' => 'post.show',
]]);
Route::resource('tag','TagController');
Route::resource('answer','AnswerController', ['only' => ['store','edit','update']]);
Route::resource('comment','CommentController',['only' => ['store']]);

Route::get('profile/{username}', 'User\UserController@profile')->name('profile.name');
Route::post('profile', 'User\UserController@updateAvatar')->middleware('auth');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
{
		Route::get('login', 'AdminHomeController@getLogin');
		Route::post('login', 'AdminHomeController@postLogin');
		Route::get('loginout', 'AdminHomeController@loginout');

		Route::group(['middleware'=> 'adminAuth'],function(){
				Route::get('/', 'AdminHomeController@index');
				Route::get('questions', 'QuestionController@index');
				Route::put('questions/{question}', 'QuestionController@update')->name('questionAdminUpdate');
				Route::get('questions/{question}/edit', 'QuestionController@edit')->name('questionAdminEdit');
				Route::delete('questions/{question}', 'QuestionController@destroy')->name('questionAdminDelete');
				Route::get('questions/{question}', 'QuestionController@show')->name('questionAdminShow');
				Route::resource('users','UserController', ['only' => ['index', 'edit', 'destroy']]);
	});
});
