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


Route::post('/login', 'UsersController@ramenLogin');
Route::post('/check', 'UsersController@ramenCheck');
Route::post('/register', 'UsersController@create');
Route::group(['prefix' => 'users'], function(){
    Route::get('/','UsersController@getCollection');
    Route::get('/{id}', 'UsersController@getItem'); 
    Route::get('/register', 'UsersController@getRegister');
    // Route::group(['middleware' => 'jwt'], function(){
        Route::post('/', 'UsersController@postItem');
        Route::put('/{id}', 'UsersController@putItem');
        Route::post('/{id}/update', 'UsersController@putItem');
        Route::delete('/{id}', 'UsersController@deleteItem');
});
Route::post('/users/{id}/add_roles', 'UsersController@addRoles');
Route::post('/users/{id}/remove_roles', 'UsersController@removeRoles');
Route::post('/register', 'UsersController@register');

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
