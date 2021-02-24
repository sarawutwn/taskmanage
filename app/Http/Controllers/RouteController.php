<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;

class RouteController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function index(Request $request)
    {
        return view('index');
    }
}
