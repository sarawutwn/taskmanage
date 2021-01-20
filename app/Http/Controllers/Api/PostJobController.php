<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostJob;
use Illuminate\Support\Carbon;

class PostJobController extends Controller
{
    public function workInCheck(){

            $user = auth()->user();
            $postJob = PostJob::create([
               "user_id" => $user->id,
               "date" => Carbon::now(),
                "update_to_report" => false
            ]);
            if(!$postJob){
               return response()->json(['status' => '400', 'message' => "Try again."], 400);
            }else{
             return response()->json(['status' => '200', 'message' => "You are check-in successfully.", 'data' => ['firstname' => $user->firstname, 'lastname' => $user->lastname, 'check_in_date' => $postJob->date->toDateTimeString()]], 200);
            }
    }

    public function getCheckIn(Request $request){
        $user = $request->user();
        $postJob = PostJob::where("user_id", $user->id)
                            ->where('update_to_report', false)->get();
        $date = $postJob->pluck('date');
        return response()->json(['status' => '200', 'message' => 'Get Check-in today successfully.', 'data' => $postJob], 200);
        // return response()->json(['status' => '200', 'message' => 'Get Check-in today successfully.', 'data' => ['check-in_count_today' => $date->count(), 'check_in_time' => $date, ]], 200);
    }
}
