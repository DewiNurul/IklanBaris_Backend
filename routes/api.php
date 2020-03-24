<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

// //user
// Route::post('user', 'UserController@store');
// Route::put('user/{id}', 'UserController@ubah');
// Route::get('user/{limit}/{offset}', 'UserController@getAll');
// Route::get('user/{id}', 'UserController@show');
// Route::delete('user/{id}', 'UserController@delete');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
