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


Route::group(['prefix' => 'users'], function(){
    Route::get('/','UserController@getCollection');
    Route::get('/{id}', 'UserController@getItem'); 
        Route::post('/', 'UserController@postItem');
        Route::put('/{id}', 'UserController@putItem');
        Route::post('/{id}/update', 'UserController@putItem');
        Route::delete('/{id}', 'UserController@deleteItem');
});

Route::group(['prefix' => 'projects'], function(){
    Route::get('/','ProjectController@getCollection');
    Route::get('/{id}', 'ProjectController@getItem'); 
        Route::post('/', 'ProjectController@postItem');
        Route::put('/{id}', 'ProjectController@putItem');
        Route::post('/{id}/update', 'ProjectController@putItem');
        Route::delete('/{id}', 'ProjectController@deleteItem');
});

Route::group(['prefix' => 'points'], function(){
    Route::get('/','PointController@getCollection');
    Route::get('/{id}', 'PointController@getItem'); 
        Route::post('/', 'PointController@postItem');
        Route::put('/{id}', 'PointController@putItem');
        Route::post('/{id}/update', 'PointController@putItem');
        Route::delete('/{id}', 'PointController@deleteItem');
});
