<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->username;
        $password = $request->password;

        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            Auth::attempt(['email' => $username, 'password' => $password]);
        } else {
            Auth::attempt(["username" => $username, "password" => $password]);
        }

        if (Auth::check()) {
            return response()->json(['status' => '200', 'message' => 'Login successfully.']);
        } else {
            return response()->json(['status' => '404', 'message' => 'Login error.']);
        }
    }

    public function createUser(Request $request)
    {
        $users = new User;
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            // 'role' => 'required'
        ]);
        //role = REQUEST,APPROVED,NOT_APPROVE

        $users->create([
            "username" => $request->username,
            "password" => Hash::make($request->password),
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "email" => $request->email,
            "role" => "REQUEST",
        ]);
        return response()->json(['status' => '200', 'message' => 'Create id successfully.']);
    }

    public function approve(Request $request)
    {
        $user = new User;

        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->id;

        $user = User::where('id', $id)->get();

        if (!$user->isEmpty()) {
            User::where('id', $id)->update(['role' => 'APPROVED']);
            return response()->json(['status' => '200', 'message' => 'User is approved']);
        } else {
            return response()->json(['status' => '404', 'message' => 'User not approved']);
        }
    }
}
