<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $message = [
            'username.required' => 'The username field is required',
            'password.required' => 'The password field is required',
            'password.min' => 'The password must be at least 8 characters',
        ];

        $valid = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:8',
        ], $message);

        if ($valid->fails()) {
            return response()->json(['status' => '400', 'message' => $valid->errors()], 400);
        } else {
            $username = $request->username;
            $password = $request->password;

            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                Auth::attempt(['email' => $username, 'password' => $password]);
            } else {
                Auth::attempt(["username" => $username, "password" => $password]);
            }

            if (Auth::check()) {
                $token = auth()->user()->createToken('task_manager')->accessToken;

                $response = [
                    'token' => $token,
                    'username' => auth()->user()->username,
                    'user_code' => auth()->user()->user_code
                ];

                return response()->json(['status' => '200', 'message' => 'Login success', 'data' => $response], 200);
            } else {
                return response()->json(['status' => '500', 'message' => 'Login error'], 500);
            }
        }
    }

    public function createUser(Request $request)
    {
        $message = [
            'username.required' => 'The username field is required',
            'username.unique' => 'The username field is exists',
            'password.required' => 'The password field is required',
            'password.min' => 'The password must be at least 8 characters',
            'firstname.required' => 'The firstname field is required',
            'lastname.required' => 'The lastname field is required',
            'email.required' => 'The email field is required',
            'email.unique' => 'The email field is exists',
        ];

        $valid = Validator::make($request->all(), [
            'username' => ['required', 'unique:users,username'],
            'password' => 'required|min:8',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => ['required', 'unique:users,email'],
        ], $message);

        if ($valid->fails()) {
            return response()->json(['status' => '400', 'message' => $valid->errors()], 400);
        } else {
            $users = User::create([
                "username" => $request->username,
                "password" => Hash::make($request->password),
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "email" => $request->email,
                "user_code" => $this->generateRandomString(),
                "role" => "USER",
            ]);

            $users->createToken('task_manager')->accessToken;
            return response()->json(['status' => '200', 'message' => 'success'], 200);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return response()->json([
          'status' => '200',
          'message' => 'Successfully logged out'], 200);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
