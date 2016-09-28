<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function(){
    Route::get('login', ['as' => 'login', 'uses' => 'Jsdecena\Bridge\Http\Controllers\LoginController@index']);
    Route::post('login', ['as' => 'login', 'uses' => 'Jsdecena\Bridge\Http\Controllers\LoginController@store']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'Jsdecena\Bridge\Http\Controllers\LoginController@logout']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', ['as' => 'admin', 'uses' => 'Jsdecena\Bridge\Http\Controllers\AdminController@index']);
});