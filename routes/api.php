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
Route::get('/scannerCheck', 'Api\PostJobController@scanCheck')->name('scan.check');
Route::post('register', 'Api\UserController@createUser');
Route::post('login', 'Api\UserController@login');
Route::get('report', 'Api\ReportController@reportByMemberId')->name('report.project');
Route::post('loginWithWebServer', 'Api\UserController@loginWithWebServer');

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', 'Api\UserController@logout')->name('logout');
    Route::get('/user', 'Api\UserController@user')->name('user');
    Route::post('/checkin', 'Api\PostJobController@workInCheck')->name('checkin');
    Route::get('/getCheckInToday', 'Api\PostJobController@getCheckIn')->name('getCheckIn');
    Route::get('/getReportJob', 'Api\PostJobReportController@getReport')->name('getReport');
    Route::get('/getReportJobAll', 'Api\PostJobReportController@getReportAll')->name('getReportAll');

    Route::prefix('/project')->group(function () {
        Route::get('/get', 'Api\ProjectController@show')->name('get');
        Route::get('/getByToken', 'Api\ProjectController@getByToken')->name('get.token');
        Route::get('/get/all', 'Api\ProjectController@showAll')->name('get.all');
        Route::post('/add', 'Api\ProjectController@store')->name('add');
        Route::post('/edit', 'Api\ProjectController@update')->name('edit');
        Route::post('/delete', 'Api\ProjectController@destroy')->name('delete');
        Route::post('/getMemberOut', 'Api\ProjectController@getMemberOut')->name('get.outMember');
        Route::post('/restore', 'Api\ProjectController@restore')->name('restore.project');

        Route::prefix('/member')->group(function () {
            Route::post('/get', 'Api\ProjectMemberController@getMemberByProjectId')->name('member.get');
            Route::get('/get/project', 'Api\ProjectMemberController@getMyProject')->name('member.get.project');
            Route::post('/add', 'Api\ProjectMemberController@addMember')->name('member.add');
            Route::post('/delete', 'Api\ProjectMemberController@deleteMember')->name('member.delete');

            Route::prefix('/case')->group(function () {
                Route::post('/add', 'Api\ProjectCaseController@addCase')->name('case.add');
                Route::post('/edit', 'Api\ProjectCaseController@editCase')->name('case.edit');
                Route::post('/delete', 'Api\ProjectCaseController@deleteCase')->name('case.delete');
                Route::post('/update', 'Api\ProjectCaseController@updateStatus')->name('case.update');
                Route::post('/open', 'Api\ProjectCaseController@openCase')->name('case.open');
                Route::get('/getAll', 'Api\ProjectCaseController@getAll')->name('case.get.all');
                Route::get('/getCaseById', 'Api\ProjectCaseController@getCaseById')->name('case.show.ById');
                Route::get('/getCaseByToken', 'Api\ProjectCaseController@getCaseByToken')->name('case.get.byToken');
                Route::get('/getStatusCount', 'Api\ProjectCaseController@getStatusCount')->name('case.get.status.count');
                Route::post('/getProject', 'Api\ProjectCaseController@getProjectFromCase')->name('case.get.project');
                Route::post('/getCaseByProjectId', 'Api\ProjectCaseController@getCaseByProjectId')->name('case.get.project.by.id');
                Route::get('/getCaseInProcess', 'Api\ProjectCaseController@getCaseInProcess')->name('case.get.project.process');
                Route::post('/getCaseInProcessByProjectId', 'Api\ProjectCaseController@getCaseInProcessByProjectId')->name('case.get.project.process.id');
                Route::get('/getCaseEndAndProcess', 'Api\ProjectCaseController@getCaseEndAndProcess')->name('case.get.with.endAndProcess');

                Route::prefix('/logtime')->group(function () {
                    Route::post('/timeStart', 'Api\LogTimeController@startTime')->name('logtime.start');
                    Route::post('/timeEnd', 'Api\LogTimeController@endTime')->name('logTime.end');
                });
            });
        });
    });
});
