<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Generator;
use Illuminate\Http\Request;
use App\Models\Random;

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

Route::get('/register', function () {
    return view('register');
});

Route::get('/', function () {
    $random = Random::first();
    $qrcode = new Generator;
    $qr = $qrcode->size(300)->generate($random->random_string);
    return view('qrcode', [
        'qr' => $qr
    ]);
});
