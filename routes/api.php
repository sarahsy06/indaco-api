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
    // Route::get('/register', 'UserController@getRegister');
    Route::post('/', 'UserController@postItem');
    Route::put('/{id}', 'UserController@putItem');
    Route::post('/{id}/update', 'UserController@putItem');
    Route::delete('/{id}', 'UserController@deleteItem');

});
Route::post('/users/{id}/add_roles', 'UserController@addRoles');
Route::post('/users/{id}/remove_roles', 'UserController@removeRoles');
Route::post('/register', 'UserController@register');
Route::get('/register', 'UserController@register');
// Route::post('/login', 'UserController@login');
Route::get('/login', 'UserController@login')->middleware('auth.basic');
Route::post('/login', 'UserController@login');
Route::post('/check', 'UserController@ramenCheck');
Route::post('/passwordresets','PasswordResetController@reset');
Route::get('/passwordresets','PasswordResetController@reset');
// Route::post('/register', 'UserController@create');
// Route::get('/register', 'UserController@getRegister');

Route::get('password/email', ['as' => 'password/email', 'uses' => 'Auth\PasswordController@getEmail']);
// Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');
Route::post('/refresh','\App\Http\Controllers\UserController@refreshToken');

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

Route::group(['prefix' => 'roles'], function(){
    Route::get('/','RoleController@getCollection');
    Route::get('/{id}', 'RoleController@getItem');  
        Route::post('/', 'RoleController@postItem');
        Route::put('/{id}', 'RoleController@putItem');
        Route::post('/{id}/update', 'RoleController@putItem');
        Route::delete('/{id}', 'RoleController@deleteItem');
});
