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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/tags', function (Request $request) {
    $tags = \App\Tag::select(['id','name'])
        ->where('name','like','%'.$request->query('q').'%')
        ->get();
    return $tags;
})->middleware('api');

Route::post('answer/{id}/votes/users','VoteController@users')->middleware('auth:api');
Route::post('answer/vote','VoteController@vote')->middleware('auth:api');
