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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('signup', 'AuthController@signup')->name('signup');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});


Route::apiResource('/questions', 'QuestionController');

Route::apiResource('/categories', 'CategoryController');

Route::apiResource('/questions/{question}/replies', 'ReplyController');

Route::post('/questions/{question}/replies/{reply}/like', 'LikeController@like');
Route::delete('/questions/{question}/replies/{reply}/unlike', 'LikeController@unlike');

Route::post('notifications', 'NotificationController@index');
Route::post('markAsRead', 'NotificationController@markAsRead');