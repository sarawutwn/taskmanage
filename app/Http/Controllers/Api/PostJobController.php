<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostJob;
use App\Models\User;
use App\Models\Random;
use Illuminate\Support\Carbon;
use SimpleSoftwareIO\QrCode\Generator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PostJobController extends Controller
{
    public function workInCheck()
    {

        $user = auth()->user();
        $postJob = PostJob::create([
            "user_id" => $user->id,
            "date" => Carbon::now(),
            "update_to_report" => false
        ]);
        if (!$postJob) {
            return response()->json(['status' => '400', 'message' => "Try again."], 400);
        } else {
            return response()->json(['status' => '200', 'message' => "You are check-in successfully.", 'data' => ['firstname' => $user->firstname, 'lastname' => $user->lastname, 'check_in_date' => $postJob->date->toDateTimeString()]], 200);
        }
    }

    public function getCheckIn(Request $request)
    {
        $user = $request->user();
        $postJob = PostJob::where("user_id", $user->id)
            ->where('update_to_report', false)->get();
        $date = $postJob->pluck('date');
        return response()->json(['status' => '200', 'message' => 'Get Check-in today successfully.', 'data' => $postJob], 200);
        // return response()->json(['status' => '200', 'message' => 'Get Check-in today successfully.', 'data' => ['check-in_count_today' => $date->count(), 'check_in_time' => $date, ]], 200);
    }

    public function scanCheck(Request $request)
    {
        $random = Random::where('random_string', $request->random)->first();
        if (empty($random)) {
            return response()->json(['status' => '400', 'message' => "Check in not successfully."], 400);
        } else {
            $random->delete();

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 10; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            Random::create([
                'random_string' => $randomString
            ]);

            $user = User::where('user_code', $request->user_code)->first();
            $postJob = PostJob::create([
                "user_id" => $user->id,
                "date" => Carbon::now(),
                "update_to_report" => false
            ]);
            if (!$postJob) {
                return response()->json(['status' => '400', 'message' => "Try again."], 400);
            } else {
                return response()->json(['status' => '200', 'message' => "You are check-in successfully.", 'data' => ['firstname' => $user->firstname, 'lastname' => $user->lastname, 'check_in_date' => $postJob->date->toDateTimeString()]], 200);
            }
        }
    }

    public function scanCheckWithSubmit(Request $request)
    {
        $message = [
            'username.required' => 'The username field is required',
            'username.string' => 'The username type string only',
            'password.required' => 'The password field is required',
            'password.min' => 'The password must be at least 8 characters',
            'password.string' => 'The password type string only',
            'code.required' => 'The Code is someting went wrong'
        ];

        $valid = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:8',
            'code' => 'required'
        ], $message);

        if ($valid->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator Error', 'errors' => $valid->errors()], 400);
        } else {
            $username = $request->username;
            $password = $request->password;
            $code = $request->code;

            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                Auth::attempt(['email' => $username, 'password' => $password]);
            } else {
                Auth::attempt(["username" => $username, "password" => $password]);
            }

            if (Auth::check()) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 6; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                ///// ทำตค่อตรงนี้
                $userCode = User::where('user_code', $code)->first();
                $userCode->user_code = $randomString;
                $result = $userCode->save();

                PostJob::create([
                    "user_id" => $userCode->id,
                    "date" => Carbon::now(),
                    "update_to_report" => false
                ]);

                if ($result) {
                    return response()->json(['status' => '200', 'message' => 'Login success', 'data' => $userCode], 200);
                } else {
                    return response()->json(['status' => '400', 'message' => 'Login error', 'errors' => 'QRcode not for you!'], 400);
                }
            } else {
                return response()->json(['status' => '400', 'message' => 'Login error', 'errors' => 'username or password invalid'], 400);
            }
        }
    }

    //     public function generate(Request $request)
    //     {
    //         $qrcode = new Generator;
    //         $qr = $qrcode->size(300)->generate('http://10.5.40.231:8000/checkin');
    //         return view('qrcode', ['qr' => $qr]);
    //     }
    // }
}
