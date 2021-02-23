<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function register()
    {
        return view('register');
    }
}
