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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return auth()->user();
});

Route::post('register', 'Api\UserController@createUser');
Route::post('login', 'Api\UserController@login');

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', 'Api\UserController@logout')->name('logout');
    Route::get('/user', 'Api\UserController@user')->name('user');
    Route::post('/checkin', 'Api\PostJobController@workInCheck')->name('checkin');
    Route::get('/getCheckIn', 'Api\PostJobController@getCheckIn')->name('getCheckIn');
    Route::get('/getReportJob', 'Api\PostJobReportController@getReport')->name('getReport');

    Route::prefix('/project')->group(function (){
        Route::get('/get', 'Api\ProjectController@show')->name('get');
        Route::get('/get/all', 'Api\ProjectController@showAll')->name('get.all');
        Route::post('/add', 'Api\ProjectController@store')->name('add');
        Route::post('/edit', 'Api\ProjectController@update')->name('edit');
        Route::post('/delete', 'Api\ProjectController@destroy')->name('delete');

        Route::prefix('/member')->group(function (){
            Route::get('/get', 'Api\ProjectMemberController@getMemberByProjectId')->name('member.get');
            Route::get('/get/project', 'Api\ProjectMemberController@getMyProject')->name('member.get.project');
            Route::post('/add', 'Api\ProjectMemberController@addMember')->name('member.add');

        });
    });
});
