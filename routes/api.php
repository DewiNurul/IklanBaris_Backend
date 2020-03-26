<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

//user
Route::get('user', 'UserController@index');
// Route::post('user', 'UserController@store');
// Route::put('user/{id}', 'UserController@ubah');
// Route::get('user/{id}', 'UserController@show');
// Route::delete('user/{id}', 'UserController@delete');

//barang
Route::post('barang', 'BarangController@store');
Route::put('barang/{id}', 'BarangController@update');
Route::get('barang', 'BarangController@index');
Route::get('barang/{id}', 'BarangController@show');
Route::delete('barang/{id}', 'BarangController@delete');




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
