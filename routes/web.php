<?php

use App\Http\Controllers\RouteController;
use App\Http\Controllers\RouteAdminController;
use App\Http\Controllers\RouteSupportController;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Generator;
use Illuminate\Http\Request;
use App\Models\Random;
use Symfony\Component\Routing\RouteCompiler;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/register', function () {
//     return view('register');
// });

// Route::get('/', function () {

//     $qrcode = new Generator;
//     $qr = $qrcode->size(300)->generate('http://10.5.40.231:8000/checkin=11');
// return view('index', [
//     'qr' => $qr
// ]);
// });

//USER ROLE
Route::get('/', [RouteController::class, 'login'])->name('welcome');
Route::get('/login', [RouteController::class, 'login'])->name('login');
Route::get('/register', [RouteController::class, 'register'])->name('register');
Route::get('/index', [RouteController::class, 'index'])->name('index');
Route::get('/project={id}&name={username}', [RouteController::class, 'project'])->name('project.{id}.{username}');
Route::get('/checkin={username}', [RouteController::class, 'checkin'])->name('checkin.{username}');
Route::get('/submit={code}', [RouteController::class, 'submitForm']);

Route::view('master', 'layouts.master');
Route::view('index', 'index');
Route::view('/project/add', 'projrct.add_project');

//ADMIN ROLE
Route::prefix('/admin')->group(function () {
    Route::get('/index', [RouteAdminController::class, 'index']);
    Route::view('cases', 'admin.cases.cases_home');
    Route::view('projectAll', 'admin.project.all_project');
    Route::get('/project={id}&name={username}', [RouteAdminController::class, 'project'])->name('admin.project.{id}.{username}');
    Route::get('/checkin={username}', [RouteAdminController::class, 'checkin'])->name('admin.checkin.{username}');
    Route::get('/edit/project={id}', [RouteAdminController::class, 'editPage']);
});

//SUPPORT ROLE
Route::prefix('/support')->group(function () {
    Route::get('/index', [RouteSupportController::class, 'index']);
    Route::get('/checkin={username}', [RouteSupportController::class, 'checkin'])->name('support.checkin.{username}');
    Route::get('/edit/project={id}', [RouteSupportController::class, 'editPage']);
});
