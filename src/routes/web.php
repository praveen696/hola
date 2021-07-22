<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'web'], function () {
    
    Route::get('/', [
        'uses' => 'App\Http\Controllers\AppController@index',
        'as' => 'home',
    ]);

    Route::get('/signin', [
        'uses' => 'App\Http\Controllers\AuthController@showLogin',
        'as' => 'login'
    ]);
    Route::post('/signin', [
        'uses' => 'App\Http\Controllers\AuthController@login',
        'as' => 'signin'
    ]);

    Route::get('/logout', [
        'uses' => 'App\Http\Controllers\AuthController@getLogout',
        'as' => 'logout'
    ]);

    Route::get('/users', [
        'uses' => 'App\Http\Controllers\UserController@index',
        'as' => 'users',
        'middleware' => 'permission',
        'role' => 'Admin'
    ]);

    Route::get('/users/create', [
        'uses' => 'App\Http\Controllers\UserController@showCreate',
        'as' => 'users.create',
        'middleware' => 'permission',
        'role' => 'Admin'
    ]);
    Route::post('/users/create', [
        'uses' => 'App\Http\Controllers\UserController@create',
        'as' => 'users.create.post',
        'middleware' => 'permission',
        'role' => 'Admin'
    ]);

    Route::get('/users/edit/{id}', [
        'uses' => 'App\Http\Controllers\UserController@showEdit',
        'as' => 'users.edit',
        'middleware' => 'permission',
        'role' => 'Admin'
    ]);
    Route::post('/users/edit/{id}', [
        'uses' => 'App\Http\Controllers\UserController@edit',
        'as' => 'users.edit.post',
        'middleware' => 'permission',
        'role' => 'Admin'
    ]);

    Route::post('/users/delete/{id}', [
        'uses' => 'App\Http\Controllers\UserController@delete',
        'as' => 'users.delete',
        'middleware' => 'permission',
        'role' => 'Admin'
    ]);

    Route::get('/page/1', [
        'uses' => 'App\Http\Controllers\PageController@page1',
        'as' => 'page1',
        'middleware' => 'permission',
        'role' => 'PAGE_1'
    ]);
    
    Route::get('/page/2', [
        'uses' => 'App\Http\Controllers\PageController@page2',
        'as' => 'page2',
        'middleware' => 'permission',
        'role' => 'PAGE_2'
    ]);
});
