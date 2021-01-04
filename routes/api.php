<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::post('register', 'Api\UserController@createUser');

// Route::post('login', 'Api\UserController@login');

// Route::post('logout', 'Api\UserController@logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return auth()->user();
});


Route::post('register', 'Api\UserController@createUser');
Route::post('login', 'Api\UserController@login');

Route::middleware('auth:api')->group(function () {
        Route::get('/logout', 'Api\UserController@logout')->name('logout');
        Route::get('/user', 'Api\UserController@user')->name('user');
    });

