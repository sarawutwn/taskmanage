<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function createUser(Request $request){
        $users = new User;
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);
        $users->create($request->all());
        return response()->json(['status' => '200', 'message' => 'Create id successfully.']);
    }
}
