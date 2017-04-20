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

Route::post('/post/follower', function (Request $request) {
    $user = Auth::guard('api')->user();
    $followed = $user->followed($request->get('post'));
    if($followed) {
        return response()->json(['followed' => true]);
    }
    return response()->json(['followed' => false]);
})->middleware('auth:api');

Route::post('/post/follow', function (Request $request) {
    $user = Auth::guard('api')->user();
    $post = \App\Post::find($request->get('post'));
    $followed = $user->followThis($post->id);
    if(count($followed['detached']) > 0) {
        $post->decrement('followers_count');
        return response()->json(['followed' => false]);
    }
    $post->increment('followers_count');
    return response()->json(['followed' => true]);
})->middleware('auth:api');

Route::get('/user/followers/{id}','FollowersController@index')->middleware('auth:api');
Route::post('/user/follow','FollowersController@follow')->middleware('auth:api');

Route::post('answer/{id}/votes/users','VoteController@users')->middleware('auth:api');
Route::post('answer/vote','VoteController@vote')->middleware('auth:api');
